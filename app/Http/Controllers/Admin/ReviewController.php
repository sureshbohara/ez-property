<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ReviewRequest;
use App\Services\Admin\ReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends BaseController
{
    public function __construct(protected ReviewService $service) {
        $this->middleware('auth:admin');
        $this->middleware('can:review.read')->only('index');
        $this->middleware('can:review.create')->only(['create', 'store']);
        $this->middleware('can:review.update')->only(['edit', 'update', 'toggleStatus', 'updateOrderLevel']);
        $this->middleware('can:review.delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $filters = $request->only('status', 'display_on', 'name');
        
        return view('admin.review.index', [
            'reviews' => $this->service->getReviews($filters),
            'filters' => $filters,
        ]);
    }

    public function create()
    {
        return view('admin.review.form');
    }

    public function store(ReviewRequest $request): JsonResponse
    {
        $review = $this->service->storeReview($request->validated());
        return $this->successJson('Review created!', $review, 201);
    }

    public function edit(Review $review)
    {
        return view('admin.review.form', ['review' => $review]);
    }

    public function update(ReviewRequest $request, Review $review): JsonResponse
    {
        $updated = $this->service->updateReview($review->id, $request->validated());
        return $this->successJson('Review updated!', $updated);
    }

    public function destroy(Review $review)
    {
        $this->service->deleteReview($review->id);
        return redirect()->back()->with('success', 'Review deleted permanently!');
    }

    public function reviewStatus(Request $request): JsonResponse
    {
        $request->validate(['status_id' => 'required|exists:reviews,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id'          => 'required|exists:reviews,id',
            'order_level' => 'required|integer|min:0',
        ]);
        $this->service->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order updated!');
    }
}