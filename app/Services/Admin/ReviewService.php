<?php

namespace App\Services\Admin;

use App\Models\Review;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ReviewService
{
    public function __construct(protected Review $review, protected MediaService $mediaService) {}

    public function getReviews(array $filters = [])
    {
        return $this->review->query()
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
            ->paginate(15)
            ->appends($filters);
    }

    public function storeReview(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            }
            return $this->review->create($data);
        });
    }

    public function updateReview(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $review = $this->review->findOrFail($id);

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $this->mediaService->deleteImageVariants($review->image);
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            } elseif (array_key_exists('image', $data) && $data['image'] === null) {
                $this->mediaService->deleteImageVariants($review->image);
                $data['image'] = null;
            } else {
                unset($data['image']);
            }

            $review->update($data);
            return $review->fresh();
        });
    }

    public function deleteReview(int $id): bool
    {
        $review = $this->review->findOrFail($id);
        if ($review->image) {
            $this->mediaService->deleteImageVariants($review->image);
        }
        return $review->delete();
    }

    public function toggleStatus(int $id): bool
    {
        $review = $this->review->findOrFail($id);
        $review->status = !$review->status;
        $review->save();
        return $review->status;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        $review = $this->review->findOrFail($id);
        $review->order_level = $orderLevel;
        $review->save();
        return true;
    }
}