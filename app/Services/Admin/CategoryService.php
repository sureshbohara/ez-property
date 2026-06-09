<?php

namespace App\Services\Admin;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryService
{
    public function __construct(protected Category $category, protected MediaService $mediaService) {}

    public function getCategories(array $filters = [])
    {
        return $this->category->query()

            ->when(!empty($filters['status']), function ($q) use ($filters) {
                $q->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN));
            })

            ->when(!empty($filters['parent_id']), function ($q) use ($filters) {
                $q->where('parent_id', $filters['parent_id']);
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

    public function storeCategory(array $data)
    {
        return DB::transaction(function () use ($data) {
            

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            }
            
            if (auth('admin')->check()) {
                $data['created_by'] = auth('admin')->id();
                $data['updated_by'] = auth('admin')->id();
            }
            
            return $this->category->create($data);
        });
    }

    public function updateCategory(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $category = $this->category->findOrFail($id);
            
         
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $this->mediaService->deleteImageVariants($category->image);
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            } elseif (array_key_exists('image', $data) && $data['image'] === null) {
                $this->mediaService->deleteImageVariants($category->image);
                $data['image'] = null;
            } else {
                unset($data['image']);
            }
            
            if (auth('admin')->check()) {
                $data['updated_by'] = auth('admin')->id();
            }
            
            $category->update($data);
            return $category->fresh();
        });
    }

    public function deleteCategory(int $id): bool
    {
        $category = $this->category->findOrFail($id);
        
        if ($category->children()->where('status', true)->exists()) {
            throw new \RuntimeException('Cannot delete category with active child categories');
        }
        
        if ($category->image) {
            $this->mediaService->deleteImageVariants($category->image);
        }
        
        return $category->delete();
    }

    public function toggleStatus(int $id): bool
    {
        $category = $this->category->findOrFail($id);
        $category->status = !$category->status;
        $category->save();
        return $category->status;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        $category = $this->category->findOrFail($id);
        $category->order_level = $orderLevel;
        $category->save();
        return true;
    }

  
}