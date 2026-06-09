<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CategoryRequest;
use App\Services\Admin\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends BaseController
{
    public function __construct(protected CategoryService $service) {

        $this->middleware('auth:admin');
        $this->middleware('can:category.read')->only(['index', 'getCategoriesAjax']);
        $this->middleware('can:category.create')->only(['create', 'store']);
        $this->middleware('can:category.update')->only(['edit', 'update', 'toggleStatus', 'updateOrderLevel']);
        $this->middleware('can:category.delete')->only('destroy');
    }

    public function index(Request $request){
        $filters = $request->only('status', 'parent_id', 'display_on', 'name');
        
        return view('admin.category.index', [
            'categories' => $this->service->getCategories($filters),
            'filters' => $filters,
            'parentCategories' => Category::whereNull('parent_id')->orderBy('name')->get(),
        ]);
    }

    public function create(){
        return view('admin.category.form', [
            'parentCategories' => Category::whereNull('parent_id')->orderBy('name')->get(),
        ]);
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        $category = $this->service->storeCategory($request->validated());
        return $this->successJson('Category created!', $category, 201);
    }

    public function edit(Category $category){
        return view('admin.category.form', [
            'category' => $category,
            'parentCategories' => Category::whereNull('parent_id')
                ->where('id', '!=', $category->id)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $updated = $this->service->updateCategory($category->id, $request->validated());
        return $this->successJson('Category updated!', $updated);
    }

    public function destroy(Category $category){
        try {
            $this->service->deleteCategory($category->id);
            return redirect()->back()->with('success', 'Category deleted permanently!');
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function toggleStatus(Request $request): JsonResponse
    {
        $request->validate(['status_id' => 'required|exists:categories,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id'          => 'required|exists:categories,id',
            'order_level' => 'required|integer|min:0',
        ]);
        $this->service->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order updated!');
    }
}