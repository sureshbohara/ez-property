<?php

namespace App\Services\Admin;

use App\Models\Service;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceService
{
    public function __construct(protected Service $service, protected MediaService $mediaService) {}

    public function getServices(array $filters = []){
        return $this->service->query()
            ->when(!empty($filters['status']), fn($q) => $q->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN)))
            ->when(!empty($filters['title']), fn($q) => $q->where('title', 'like', '%'.$filters['title'].'%'))
            ->ordered()
            ->paginate(15)
            ->appends($filters);
    }

    public function storeService(array $data){
        return DB::transaction(function () use ($data) {
                       
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
            
            return $this->service->create($data);
        });
    }

    public function updateService(int $id, array $data){
        return DB::transaction(function () use ($id, $data) {
            $service = $this->service->findOrFail($id);

            
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $this->mediaService->deleteImageVariants($service->image);
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            } elseif (array_key_exists('image', $data) && $data['image'] === null) {
                $this->mediaService->deleteImageVariants($service->image);
                $data['image'] = null;
            } else {
                unset($data['image']);
            }
            
            if (isset($data['feature_image']) && $data['feature_image'] instanceof UploadedFile) {
                $this->mediaService->deleteImageVariants($service->feature_image);
                $path = $this->mediaService->uploadImage($data['feature_image'], 'features');
                $this->mediaService->dispatchImageProcessing($path);
                $data['feature_image'] = $path;
            } elseif (array_key_exists('feature_image', $data) && $data['feature_image'] === null) {
                $this->mediaService->deleteImageVariants($service->feature_image);
                $data['feature_image'] = null;
            } else {
                unset($data['feature_image']);
            }
            
            $service->update($data);
            return $service->fresh();
        });
    }


    public function deleteService(int $id): bool
    {
        $service = $this->service->findOrFail($id);
        
        if ($service->image) {
            $this->mediaService->deleteImageVariants($service->image);
        }
        if ($service->feature_image) {
            $this->mediaService->deleteImageVariants($service->feature_image);
        }
        
        return $service->delete();
    }


    public function toggleStatus(int $id): bool
    {
        $service = $this->service->findOrFail($id);
        $service->status = !$service->status;
        $service->save();
        return $service->status;
    }


    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        $service = $this->service->findOrFail($id);
        $service->order_level = $orderLevel;
        $service->save();
        return true;
    }


    
}