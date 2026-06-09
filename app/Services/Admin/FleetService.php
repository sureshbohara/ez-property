<?php

namespace App\Services\Admin;

use App\Models\Fleet;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FleetService
{
    public function __construct(protected Fleet $fleet, protected MediaService $mediaService) {}

    public function getFleets(array $filters = []){
        return $this->fleet->query()
            ->when(!empty($filters['status']), fn($q) => $q->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN)))
            ->when(!empty($filters['title']), fn($q) => $q->where('title', 'like', '%'.$filters['title'].'%'))
            ->ordered()
            ->paginate(15)
            ->appends($filters);
    }

    public function storeFleet(array $data){
        return DB::transaction(function () use ($data) {
            
            if (empty($data['slug']) && !empty($data['title'])) {
                $data['slug'] = $this->generateUniqueSlug($data['title']);
            }
            
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
            
            return $this->fleet->create($data);
        });
    }

    public function updateFleet(int $id, array $data){
        return DB::transaction(function () use ($id, $data) {
            $fleet = $this->fleet->findOrFail($id);
            
            if (!empty($data['title']) && $data['title'] !== $fleet->title && empty($data['slug'])) {
                $data['slug'] = $this->generateUniqueSlug($data['title'], $id);
            }
            
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $this->mediaService->deleteImageVariants($fleet->image);
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            } elseif (array_key_exists('image', $data) && $data['image'] === null) {
                $this->mediaService->deleteImageVariants($fleet->image);
                $data['image'] = null;
            } else {
                unset($data['image']);
            }
            
            if (isset($data['feature_image']) && $data['feature_image'] instanceof UploadedFile) {
                $this->mediaService->deleteImageVariants($fleet->feature_image);
                $path = $this->mediaService->uploadImage($data['feature_image'], 'features');
                $this->mediaService->dispatchImageProcessing($path);
                $data['feature_image'] = $path;
            } elseif (array_key_exists('feature_image', $data) && $data['feature_image'] === null) {
                $this->mediaService->deleteImageVariants($fleet->feature_image);
                $data['feature_image'] = null;
            } else {
                unset($data['feature_image']);
            }
            
            $fleet->update($data);
            return $fleet->fresh();
        });
    }

    public function deleteFleet(int $id): bool
    {
        $fleet = $this->fleet->findOrFail($id);
        
        if ($fleet->image) {
            $this->mediaService->deleteImageVariants($fleet->image);
        }
        if ($fleet->feature_image) {
            $this->mediaService->deleteImageVariants($fleet->feature_image);
        }
        
        return $fleet->delete();
    }

    public function toggleStatus(int $id): bool
    {
        $fleet = $this->fleet->findOrFail($id);
        $fleet->status = !$fleet->status;
        $fleet->save();
        return $fleet->status;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        $fleet = $this->fleet->findOrFail($id);
        $fleet->order_level = $orderLevel;
        $fleet->save();
        return true;
    }

    protected function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $count = 1;
        
        $query = $this->fleet->where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        while ($query->exists()) {
            $slug = $original . '-' . $count++;
        }
        
        return $slug;
    }
}