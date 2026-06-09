<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PostRequest;
use App\Services\Admin\PostService;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends BaseController
{
    public function __construct(protected PostService $service) {
        $this->middleware('auth:admin');
        $this->middleware('can:blog.read')->only('index');
        $this->middleware('can:blog.create')->only(['create', 'store']);
        $this->middleware('can:blog.update')->only(['edit', 'update', 'toggleStatus', 'toggleFeatured', 'updateOrderLevel']);
        $this->middleware('can:blog.delete')->only('destroy');
    }

    public function index(Request $request){
        $filters = $request->only('status', 'title');
        return view('admin.post.index', [
            'posts' => $this->service->getPosts($filters),
            'filters' => $filters,
        ]);
    }

    public function create(){ 
        $categories = Category::orderBy('name')->get();
        return view('admin.post.form', compact('categories')); 
    }

    public function store(PostRequest $request): JsonResponse
    {
        $post = $this->service->storePost($request->validated());
        return $this->successJson('Post created!', $post, 201);
    }

    public function edit(Post $post){ 
        $categories = Category::orderBy('name')->get();
        return view('admin.post.form', compact('post', 'categories')); 
    }

    public function update(PostRequest $request, Post $post): JsonResponse
    {
        $updated = $this->service->updatePost($post->id, $request->validated());
        return $this->successJson('Post updated!', $updated);
    }

    public function destroy(Post $post){
        $this->service->deletePost($post->id);
        return redirect()->back()->with('success', 'Post deleted permanently!');
    }

    public function toggleStatus(Request $request): JsonResponse
    {
        $request->validate(['status_id' => 'required|exists:posts,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function toggleFeatured(Request $request): JsonResponse
    {
        $request->validate(['id' => 'required|exists:posts,id']);
        $newFeatured = $this->service->toggleFeatured($request->id);
        return $this->successJson('Featured status updated', ['is_featured' => $newFeatured]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate(['id' => 'required|exists:posts,id', 'order_level' => 'required|integer|min:0']);
        $this->service->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order updated!');
    }
}