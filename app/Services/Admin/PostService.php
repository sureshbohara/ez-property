<?php

namespace App\Services\Admin;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class PostService
{
    public function __construct(protected Post $post, protected MediaService $mediaService) {}

    public function getPosts(array $filters = [])
    {
        return $this->post->query()
            ->when(isset($filters['status']) && $filters['status'] !== '', fn($q) => $q->where('status', $filters['status']))
            ->when(!empty($filters['title']), fn($q) => $q->where('title', 'like', '%' . $filters['title'] . '%'))
            ->ordered()
            ->paginate(15)
            ->appends($filters);
    }

    public function storePost(array $data){
        return DB::transaction(function () use ($data) {   

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            }

            $data['is_featured'] = isset($data['is_featured']) && $data['is_featured'] == '1';
            $data['status'] = $data['status'] ?? 'active';

            return $this->post->create($data);
        });
    }

    public function updatePost(int $id, array $data){
        return DB::transaction(function () use ($id, $data) {
            $post = $this->post->findOrFail($id);
            
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                if ($post->image) $this->mediaService->deleteImageVariants($post->image);
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            } elseif (array_key_exists('image', $data) && $data['image'] === null) {
                if ($post->image) $this->mediaService->deleteImageVariants($post->image);
                $data['image'] = null;
            } else {
                unset($data['image']);
            }

            $data['is_featured'] = isset($data['is_featured']) && $data['is_featured'] == '1';
            $data['status'] = $data['status'] ?? 'active';

            $post->update($data);
            return $post->fresh();
        });
    }

    public function deletePost(int $id): bool
    {
        $post = $this->post->findOrFail($id);
        if ($post->image) $this->mediaService->deleteImageVariants($post->image);
        return $post->delete();
    }

    public function toggleStatus(int $id): string
    {
        $post = $this->post->findOrFail($id);
        $post->status = $post->status === 'active' ? 'inactive' : 'active';
        $post->save();
        return $post->status;
    }

    public function toggleFeatured(int $id): bool
    {
        $post = $this->post->findOrFail($id);
        $post->is_featured = !$post->is_featured;
        $post->save();
        return $post->is_featured;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        $post = $this->post->findOrFail($id);
        $post->order_level = $orderLevel;
        $post->save();
        return true;
    }
}