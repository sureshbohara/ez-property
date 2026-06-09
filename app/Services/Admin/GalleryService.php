<?php

namespace App\Services\Admin;

use App\Models\Gallery;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class GalleryService
{
    public function __construct(protected Gallery $gallery, protected MediaService $mediaService) {}

    public function getGalleries(array $filters = []){
        return $this->gallery->query()
            ->whereNull('deleted_at')
            ->when(!empty($filters['status']), function ($q) use ($filters) {
                $status = filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN);
                $q->where('status', $status);
            })
            ->when(!empty($filters['display_on']), function ($q) use ($filters) {
                $q->where('display_on', $filters['display_on']);
            })
            ->when(!empty($filters['name']), function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['name'] . '%');
            })
            ->ordered()
            ->paginate(20)
            ->appends($filters);
    }

    public function storeGallery(array $data){
        return DB::transaction(function () use ($data) {
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            }
            return $this->gallery->create($data);
        });
    }

    public function updateGallery(int $id, array $data){
        return DB::transaction(function () use ($id, $data) {
            $gallery = $this->gallery->findOrFail($id);

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $this->mediaService->deleteImageVariants($gallery->image);
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            } elseif (array_key_exists('image', $data) && $data['image'] === null) {
                $this->mediaService->deleteImageVariants($gallery->image);
                $data['image'] = null;
            } else {
                unset($data['image']);
            }

            $gallery->update($data);
            return $gallery->fresh();
        });
    }

    public function deleteGallery(int $id): bool
    {
        $gallery = $this->gallery->findOrFail($id);
        if ($gallery->image) {
            $this->mediaService->deleteImageVariants($gallery->image);
        }
        return $gallery->delete();
    }

    public function toggleStatus(int $id): bool
    {
        $gallery = $this->gallery->findOrFail($id);
        $gallery->status = !$gallery->status;
        $gallery->save();
        return $gallery->status;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        $gallery = $this->gallery->findOrFail($id);
        $gallery->order_level = $orderLevel;
        $gallery->save();
        return true;
    }
}