<?php

namespace App\Services\Admin;

use App\Models\ProductVariant;
use Illuminate\Http\UploadedFile;

class ProductVariantService
{
    public function __construct(protected ProductVariant $variant, protected MediaService $mediaService) {}

    public function getVariants(int $productId) {
        return ProductVariant::where('product_id', $productId)->orderBy('id', 'asc')->get();
    }

    public function storeVariant(int $productId, array $data) {
        $data['product_id'] = $productId;
        
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $path = $this->mediaService->uploadImage($data['image'], 'products/variants');
            $this->mediaService->dispatchImageProcessing($path);
            $data['image'] = $path;
        }
        
        return ProductVariant::create($data);
    }

    public function updateVariant(int $id, array $data) {
        $variant = ProductVariant::findOrFail($id);
        
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            if ($variant->image) $this->mediaService->deleteImageVariants($variant->image);
            $path = $this->mediaService->uploadImage($data['image'], 'products/variants');
            $this->mediaService->dispatchImageProcessing($path);
            $data['image'] = $path;
        } else {
            unset($data['image']);
        }
        
        $variant->update($data);
        return $variant->fresh();
    }

    public function deleteVariant(int $id): bool {
        $variant = ProductVariant::findOrFail($id);
        if ($variant->image) $this->mediaService->deleteImageVariants($variant->image);
        return $variant->delete();
    }

    public function bulkUpdate(int $productId, array $variantsData) {
        foreach ($variantsData as $variantData) {
            if (!empty($variantData['id'])) {
                $variant = ProductVariant::find($variantData['id']);
                if ($variant) $variant->update($variantData);
            }
        }
        return true;
    }
}