<?php

namespace App\Services\Admin;

use App\Models\Brand;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class BrandService
{
    public function __construct(protected Brand $brand, protected MediaService $mediaService) {}

    public function getBrands(array $filters = []) {
        return $this->brand->query()
            ->when(!empty($filters['status']), fn($q) => $q->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN)))
            ->when(!empty($filters['name']), fn($q) => $q->where('name', 'like', '%'.$filters['name'].'%'))
            ->ordered()
            ->paginate(15)
            ->appends($filters);
    }

    public function storeBrand(array $data) {
        return DB::transaction(function () use ($data) {
            
            if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
                $path = $this->mediaService->uploadImage($data['logo'], 'brands');
                $this->mediaService->dispatchImageProcessing($path);
                $data['logo'] = $path;
            }
            return $this->brand->create($data);
        });
    }

    public function updateBrand(int $id, array $data) {
        return DB::transaction(function () use ($id, $data) {
            $brand = $this->brand->findOrFail($id);
            
            if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
                if ($brand->logo) $this->mediaService->deleteImageVariants($brand->logo);
                $path = $this->mediaService->uploadImage($data['logo'], 'brands');
                $this->mediaService->dispatchImageProcessing($path);
                $data['logo'] = $path;
            } elseif (array_key_exists('logo', $data) && $data['logo'] === null) {
                if ($brand->logo) $this->mediaService->deleteImageVariants($brand->logo);
                $data['logo'] = null;
            } else {
                unset($data['logo']);
            }
            
            $brand->update($data);
            return $brand->fresh();
        });
    }

    public function deleteBrand(int $id): bool {
        $brand = $this->brand->findOrFail($id);
        if ($brand->logo) $this->mediaService->deleteImageVariants($brand->logo);
        return $brand->delete();
    }

    public function toggleStatus(int $id): bool {
        $brand = $this->brand->findOrFail($id);
        $brand->status = !$brand->status;
        $brand->save();
        return $brand->status;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool {
        $brand = $this->brand->findOrFail($id);
        $brand->order_level = $orderLevel;
        $brand->save();
        return true;
    }
}