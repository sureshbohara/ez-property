<?php

namespace App\Services\Admin;

use App\Models\Page;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageService
{
    public function __construct(protected Page $page, protected MediaService $mediaService) {}

    public function getPages(array $filters = []){
        return $this->page->query()
            ->when(isset($filters['status']) && $filters['status'] !== '', fn($q) => $q->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN)))
            ->when(!empty($filters['title']), fn($q) => $q->where('title', 'like', '%' . $filters['title'] . '%'))
            ->ordered()
            ->paginate(15)
            ->appends($filters);
    }

    public function storePage(array $data){
        return DB::transaction(function () use ($data) {            
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            }

            $data['show_in_menu'] = isset($data['show_in_menu']) && $data['show_in_menu'] == '1';
            $data['show_in_footer'] = isset($data['show_in_footer']) && $data['show_in_footer'] == '1';
            $data['is_featured'] = isset($data['is_featured']) && $data['is_featured'] == '1';

            return $this->page->create($data);
        });
    }

    public function updatePage(int $id, array $data){
        return DB::transaction(function () use ($id, $data) {
            $page = $this->page->findOrFail($id);
            
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                if ($page->image) $this->mediaService->deleteImageVariants($page->image);
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            } elseif (array_key_exists('image', $data) && $data['image'] === null) {
                if ($page->image) $this->mediaService->deleteImageVariants($page->image);
                $data['image'] = null;
            } else {
                unset($data['image']);
            }

            $data['show_in_menu'] = isset($data['show_in_menu']) && $data['show_in_menu'] == '1';
            $data['show_in_footer'] = isset($data['show_in_footer']) && $data['show_in_footer'] == '1';
            $data['is_featured'] = isset($data['is_featured']) && $data['is_featured'] == '1';

            $page->update($data);
            return $page->fresh();
        });
    }

    public function deletePage(int $id): bool
    {
        $page = $this->page->findOrFail($id);
        if ($page->image) $this->mediaService->deleteImageVariants($page->image);
        return $page->delete();
    }

    public function toggleStatus(int $id): bool
    {
        $page = $this->page->findOrFail($id);
        $page->status = !$page->status;
        $page->save();
        return $page->status;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        $page = $this->page->findOrFail($id);
        $page->order_level = $orderLevel;
        $page->save();
        return true;
    }
}