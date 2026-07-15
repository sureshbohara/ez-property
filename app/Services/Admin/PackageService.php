<?php

namespace App\Services\Admin;

use App\Models\Package;
use App\Models\FixedDeparture;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class PackageService
{
    public function __construct(protected Package $package, protected MediaService $mediaService) {}

    public function getPackages(array $filters = []) {
        return $this->package->query()
        ->when(!empty($filters['status']), fn($q) => $q->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN)))
        ->when(!empty($filters['name']), fn($q) => $q->where('name', 'like', '%'.$filters['name'].'%'))
        ->ordered()
        ->paginate(15)
        ->appends($filters);
    }

    public function storePackage(array $data, array $categoryIds = []) {
        return DB::transaction(function () use ($data, $categoryIds) {
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            }
            if (isset($data['feature_image']) && $data['feature_image'] instanceof UploadedFile) {
                $path = $this->mediaService->uploadImage($data['feature_image'], 'features');
                $this->mediaService->dispatchImageProcessing($path);
                $data['feature_image'] = $path;
            }
            if (isset($data['gallery']) && is_array($data['gallery'])) {
                $galleryPaths = [];
                foreach ($data['gallery'] as $file) {
                    if ($file instanceof UploadedFile) {
                        $path = $this->mediaService->uploadImage($file, 'galleries');
                        $this->mediaService->dispatchImageProcessing($path);
                        $galleryPaths[] = $path;
                    }
                }
                $data['gallery'] = $galleryPaths;
            }

            $package = $this->package->create($data);
            if (!empty($categoryIds)) {
                $package->categories()->sync($categoryIds);
            }
            return $package;
        });
    }

    public function updatePackage(int $id, array $data, array $categoryIds = []) {
        return DB::transaction(function () use ($id, $data, $categoryIds) {
            $package = $this->package->findOrFail($id);
            
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                if($package->image) $this->mediaService->deleteImageVariants($package->image);
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            } elseif (array_key_exists('image', $data) && $data['image'] === null) {
                if($package->image) $this->mediaService->deleteImageVariants($package->image);
                $data['image'] = null;
            } else { unset($data['image']); }

            if (isset($data['feature_image']) && $data['feature_image'] instanceof UploadedFile) {
                if($package->feature_image) $this->mediaService->deleteImageVariants($package->feature_image);
                $path = $this->mediaService->uploadImage($data['feature_image'], 'features');
                $this->mediaService->dispatchImageProcessing($path);
                $data['feature_image'] = $path;
            } elseif (array_key_exists('feature_image', $data) && $data['feature_image'] === null) {
                if($package->feature_image) $this->mediaService->deleteImageVariants($package->feature_image);
                $data['feature_image'] = null;
            } else { unset($data['feature_image']); }

            if (isset($data['gallery']) && is_array($data['gallery'])) {
                $existingGallery = $package->gallery ?? [];
                foreach ($data['gallery'] as $file) {
                    if ($file instanceof UploadedFile) {
                        $path = $this->mediaService->uploadImage($file, 'galleries');
                        $this->mediaService->dispatchImageProcessing($path);
                        $existingGallery[] = $path;
                    }
                }
                $data['gallery'] = $existingGallery;
            } else {
                unset($data['gallery']);
            }

            $package->update($data);
            $package->categories()->sync($categoryIds);
            return $package->fresh();
        });
    }

    public function deletePackage(int $id): bool {
        $package = $this->package->findOrFail($id);
        if ($package->image) $this->mediaService->deleteImageVariants($package->image);
        if ($package->feature_image) $this->mediaService->deleteImageVariants($package->feature_image);
        return $package->delete();
    }

    public function toggleStatus(int $id): bool {
        $package = $this->package->findOrFail($id);
        $package->status = !$package->status;
        $package->save();
        return $package->status;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool {
        $package = $this->package->findOrFail($id);
        $package->order_level = $orderLevel;
        $package->save();
        return true;
    }

    public function updateDisplayType(int $id, ?string $displayOn): bool {
        $package = $this->package->findOrFail($id);
        $package->display_on = $displayOn;
        $package->save();
        return true;
    }

    public function updatePrices(int $id, array $data): bool {
        $package = $this->package->findOrFail($id);
        $package->update([
            'trip_previous_price' => $data['trip_previous_price'] ?? $package->trip_previous_price,
            'trip_price' => $data['trip_price'] ?? $package->trip_price,
        ]);
        return true;
    }

    public function deleteGalleryImage(int $id, string $imageName): void {
        $package = $this->package->findOrFail($id);
        $gallery = $package->gallery ?? [];
        $package->gallery = array_values(array_filter($gallery, fn($img) => $img !== $imageName));
        $package->save();
    }

    public function updateItinerary(int $id, array $data): void {
        $package = $this->package->findOrFail($id);
        if (empty($data['title']) || !is_array($data['title'])) {
            $package->update(['itinerary_data' => []]);
            return;
        }

        $steps = [];
        foreach ($data['title'] as $index => $title) {
            if (empty(trim($title))) {
                continue; 
            }
            $steps[] = [
                'day_number' => $index + 1,
                'name' => strip_tags(trim($title)),
                'content' => trim($data['content'][$index] ?? ''),
                'max_elevation' => trim($data['max_elevation'][$index] ?? ''),
                'duration' => trim($data['duration'][$index] ?? ''),
                'distance' => trim($data['distance'][$index] ?? ''),
                'meals' => trim($data['meals'][$index] ?? ''),
                'accommodation' => trim($data['accommodation'][$index] ?? ''),
            ];
        }
        $package->update(['itinerary_data' => $steps]);
    }

    public function updateIncExc(int $id, array $data): void {
        $package = $this->package->findOrFail($id);
        $included = collect($data['included']['content'] ?? [])->filter(fn($c) => !empty(trim($c)))->map(fn($c) => ['content' => trim($c)])->values()->toArray();
        $excluded = collect($data['excluded']['content'] ?? [])->filter(fn($c) => !empty(trim($c)))->map(fn($c) => ['content' => trim($c)])->values()->toArray();
        $package->update(['included_data' => $included, 'excluded_data' => $excluded]);
    }

    public function updateEquipment(int $id, array $data): void {
        $package = $this->package->findOrFail($id);
        $fields = ['equipment1' => 'general', 'equipment2' => 'lower_body', 'equipment3' => 'upper_body', 'equipment4' => 'footwear', 'equipment5' => 'accessories'];
        $updateData = [];
        foreach ($fields as $inputKey => $column) {
            $items = collect($data[$inputKey]['content'] ?? [])->filter(fn($c) => !empty(trim($c)))->map(fn($c) => ['content' => trim($c)])->values()->toArray();
            $updateData[$column] = $items;
        }
        $package->update($updateData);
    }

    // Fixed Departures Methods
    public function getFixedDepartures() { 
        return FixedDeparture::with('package')->orderBy('start_date', 'asc')->paginate(15); 
    }

    public function addFixedDeparture(array $data) { 
        return FixedDeparture::create($data); 
    }

    public function deleteFixedDeparture(int $id) {
        $dep = FixedDeparture::findOrFail($id);
        if ($dep->booked_seats > 0) throw new \Exception('Cannot delete departure with existing bookings.');
        $dep->delete();
    }

    public function toggleDepartureStatus(int $id, string $status) {
        $dep = FixedDeparture::findOrFail($id);
        $dep->status = $status;
        $dep->save();
    }
}