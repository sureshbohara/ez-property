<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Models\ProductBundle;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(protected Product $product, protected MediaService $mediaService) {}

    public function getProducts(array $filters = []) {
        return $this->product->query()
            ->with(['brand', 'category'])
            ->when(!empty($filters['status']), fn($q) => $q->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN)))
            ->when(!empty($filters['name']), fn($q) => $q->where('name', 'like', '%'.$filters['name'].'%'))
            ->when(!empty($filters['product_type']), fn($q) => $q->where('product_type', $filters['product_type']))
            ->when(!empty($filters['brand_id']), fn($q) => $q->where('brand_id', $filters['brand_id']))
            ->ordered()
            ->paginate(15)
            ->appends($filters);
    }

    public function storeProduct(array $data, array $bundleProducts = []) {
        return DB::transaction(function () use ($data, $bundleProducts) {
            $data = $this->handleMedia($data, null);
            $product = $this->product->create($data);
            
            if ($product->product_type === 'grouped' && !empty($bundleProducts)) {
                $this->syncBundleProducts($product->id, $bundleProducts);
            }
            
            return $product;
        });
    }

    public function updateProduct(int $id, array $data, array $bundleProducts = []) {
        return DB::transaction(function () use ($id, $data, $bundleProducts) {
            $product = $this->product->findOrFail($id);
            $data = $this->handleMedia($data, $product);
            $product->update($data);
            
            if ($product->product_type === 'grouped') {
                $this->syncBundleProducts($product->id, $bundleProducts);
            }
            
            return $product->fresh();
        });
    }

    protected function handleMedia(array $data, ?Product $product): array {
        // Thumbnail
        if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {
            if ($product?->thumbnail) $this->mediaService->deleteImageVariants($product->thumbnail);
            $path = $this->mediaService->uploadImage($data['thumbnail'], 'products');
            $this->mediaService->dispatchImageProcessing($path);
            $data['thumbnail'] = $path;
        } elseif (array_key_exists('thumbnail', $data) && $data['thumbnail'] === null) {
            if ($product?->thumbnail) $this->mediaService->deleteImageVariants($product->thumbnail);
            $data['thumbnail'] = null;
        } else {
            unset($data['thumbnail']);
        }

        // Gallery
        if (isset($data['gallery']) && is_array($data['gallery'])) {
            $existingGallery = $product?->gallery ?? [];
            foreach ($data['gallery'] as $file) {
                if ($file instanceof UploadedFile) {
                    $path = $this->mediaService->uploadImage($file, 'products/gallery');
                    $this->mediaService->dispatchImageProcessing($path);
                    $existingGallery[] = $path;
                }
            }
            $data['gallery'] = $existingGallery;
        } else {
            unset($data['gallery']);
        }

        // Downloadable file
        if (isset($data['downloadable_file']) && $data['downloadable_file'] instanceof UploadedFile) {
            $path = $data['downloadable_file']->store('products/downloads', 'public');
            $data['downloadable_file'] = $path;
        } else {
            unset($data['downloadable_file']);
        }

        return $data;
    }

    protected function syncBundleProducts(int $productId, array $bundleProducts): void {
        ProductBundle::where('parent_product_id', $productId)->delete();
        
        foreach ($bundleProducts as $index => $bundle) {
            if (!empty($bundle['product_id'])) {
                ProductBundle::create([
                    'parent_product_id' => $productId,
                    'child_product_id' => $bundle['product_id'],
                    'quantity' => $bundle['quantity'] ?? 1,
                    'sort_order' => $index,
                ]);
            }
        }
    }

    public function deleteProduct(int $id): bool {
        $product = $this->product->findOrFail($id);
        if ($product->thumbnail) $this->mediaService->deleteImageVariants($product->thumbnail);
        return $product->delete();
    }

    public function toggleStatus(int $id): bool {
        $product = $this->product->findOrFail($id);
        $product->status = !$product->status;
        $product->save();
        return $product->status;
    }

    public function toggleFeatured(int $id): bool {
        $product = $this->product->findOrFail($id);
        $product->is_featured = !$product->is_featured;
        $product->save();
        return $product->is_featured;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool {
        $product = $this->product->findOrFail($id);
        $product->order_level = $orderLevel;
        $product->save();
        return true;
    }

    public function deleteGalleryImage(int $id, string $imageName): void {
        $product = $this->product->findOrFail($id);
        $gallery = $product->gallery ?? [];
        $product->gallery = array_values(array_filter($gallery, fn($img) => $img !== $imageName));
        $product->save();
    }
}