<?php

namespace App\Services\Admin;

use App\Models\Banner;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class BannerService
{


 
    public function __construct(protected Banner $banner, protected MediaService $mediaService) {}


    public function getBanners(array $filters = []){
        return $this->banner->query()
            ->when(!empty($filters['status']), function ($q) use ($filters) {
                $status = filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN);
                $q->where('status', $status);
            })
            ->when(!empty($filters['title']), function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['title'] . '%');
            })
            ->ordered()
            ->paginate(15)
            ->appends($filters);
    }


    public function storeBanner(array $data){
        return DB::transaction(function () use ($data) {
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            }
            return $this->banner->create($data);
        });
    }


    public function updateBanner(int $id, array $data){
        return DB::transaction(function () use ($id, $data) {
            $banner = $this->banner->findOrFail($id);

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $this->mediaService->deleteImageVariants($banner->image);
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            } elseif (array_key_exists('image', $data) && $data['image'] === null) {
                $this->mediaService->deleteImageVariants($banner->image);
                $data['image'] = null;
            } else {
                unset($data['image']);
            }

            $banner->update($data);
            return $banner->fresh();
        });
    }


    public function deleteBanner(int $id): bool
    {
        $banner = $this->banner->findOrFail($id);
        if ($banner->image) {
            $this->mediaService->deleteImageVariants($banner->image);
        }
        return $banner->delete();
    }



    public function toggleStatus(int $id): bool
    {
        $banner = $this->banner->findOrFail($id);
        $banner->status = !$banner->status;
        $banner->save();
        return $banner->status;
    }


    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        $banner = $this->banner->findOrFail($id);
        $banner->order_level = $orderLevel;
        $banner->save();
        return true;
    }
}