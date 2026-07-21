<?php

namespace App\Services\Admin;

use App\Models\Listing;
use App\Models\PricingRule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ListingService {
    public function __construct(protected Listing $listing, protected MediaService $mediaService) {}

    public function getListings(array $filters = []) {
        return $this->listing->query()
            ->with(['category', 'amenities', 'user']) 
            ->when(!empty($filters['status']), fn($q) => $q->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN)))
            ->when(!empty($filters['title']), fn($q) => $q->where('title', 'like', '%'.$filters['title'].'%'))
            ->when(!empty($filters['city']), fn($q) => $q->where('city', 'like', '%'.$filters['city'].'%'))
            ->ordered()
            ->paginate(15)
            ->appends($filters);
    }

    public function storeListing(array $data, ?int $userId = null) {
        return DB::transaction(function () use ($data, $userId) {
            if ($userId) {
                $data['user_id'] = $userId;
            }
            
            $data = $this->handleMedia($data, null);
            
            if (isset($data['highlight_key']) && is_array($data['highlight_key'])) {
                $data['highlight_key'] = array_values(array_filter($data['highlight_key'], fn($v) => !empty(trim((string)$v))));
            } else {
                $data['highlight_key'] = null; 
            }

            $listing = $this->listing->create($data);
            $this->syncRelations($listing, $data);
            
            return $listing;
        });
    }

    public function updateListing(int $id, array $data) {
        return DB::transaction(function () use ($id, $data) {
            $listing = $this->listing->findOrFail($id);
            $data = $this->handleMedia($data, $listing);

            if (isset($data['highlight_key']) && is_array($data['highlight_key'])) {
                $data['highlight_key'] = array_values(array_filter($data['highlight_key'], fn($v) => !empty(trim((string)$v))));
            } else {
                $data['highlight_key'] = null; 
            }

            $listing->update($data);
            $this->syncRelations($listing, $data);
            
            return $listing->fresh();
        });
    }

   
    protected function handleMedia(array $data, ?Listing $listing): array {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($listing?->image) {
                $this->mediaService->deleteImageVariants($listing->image);
            }
            $data['image'] = $this->mediaService->uploadImage($data['image'], 'listings');
            $this->mediaService->dispatchImageProcessing($data['image']);
        } else {
            unset($data['image']);
        }
        if (isset($data['gallery']) && is_array($data['gallery'])) {
            $existing = $listing?->gallery ?? [];
            $hasNewFiles = false;

            foreach ($data['gallery'] as $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $hasNewFiles = true;
                    $path = $this->mediaService->uploadImage($file, 'listings/gallery');
                    $this->mediaService->dispatchImageProcessing($path);
                    $existing[] = $path;
                }
            }
            if ($hasNewFiles) {
                $data['gallery'] = $existing;
            } else {
                unset($data['gallery']);
            }
        } else {
            unset($data['gallery']);
        }

        return $data;
    }

    protected function syncRelations(Listing $listing, array $data): void {
        if (isset($data['amenities'])) {
            $listing->amenities()->sync($data['amenities']);
        }
        if (isset($data['pricing_rules'])) {
            $listing->pricingRules()->delete();
            foreach ($data['pricing_rules'] as $rule) {
                if (!empty($rule['start_date']) && !empty($rule['end_date'])) {
                    $listing->pricingRules()->create($rule);
                }
            }
        }
    }

    public function deleteListing(int $id): bool {
        $listing = $this->listing->findOrFail($id);
        if ($listing->image) $this->mediaService->deleteImageVariants($listing->image);
        
        if (!empty($listing->gallery)) {
            foreach ($listing->gallery as $img) {
                $this->mediaService->deleteImageVariants($img);
            }
        }
        
        return $listing->delete();
    }

    public function toggleStatus(int $id): bool {
        $listing = $this->listing->findOrFail($id);
        $listing->status = !$listing->status;
        $listing->save();
        return $listing->status;
    }

    public function deleteGalleryImage(int $id, string $imageName): void {
        $listing = $this->listing->findOrFail($id);
        $gallery = $listing->gallery ?? [];
        $gallery = array_values(array_filter($gallery, fn($img) => $img !== $imageName));
        $listing->gallery = $gallery;
        $listing->save();
        $this->mediaService->deleteImageVariants($imageName);
    }

    public function updateDisplayType(int $id, ?string $displayOn): bool {
        $listing = $this->listing->findOrFail($id);
        $listing->display_on = $displayOn;
        $listing->save();
        return true;
    }
}