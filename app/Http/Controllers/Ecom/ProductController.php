<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\ProductRequest;
use App\Services\Admin\ProductService;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function __construct(protected ProductService $service) {
        $this->middleware('can:product.read')->only(['index']);
        $this->middleware('can:product.create')->only(['create', 'store']);
        $this->middleware('can:product.update')->only(['edit', 'update', 'toggleStatus', 'toggleFeatured', 'updateOrderLevel', 'deleteGalleryImage']);
        $this->middleware('can:product.delete')->only('destroy');
    }

    public function index(Request $request) {
        $filters = $request->only('status', 'name', 'product_type', 'brand_id');
        return view('ecom.products.index', [
            'products' => $this->service->getProducts($filters),
            'filters' => $filters,
            'brands' => Brand::active()->ordered()->get(),
        ]);
    }

    public function create() {
        $categories = Category::whereNull('parent_id')->with('children')->ordered()->get();
        $brands = Brand::active()->ordered()->get();
        $allProducts = Product::active()->orderBy('name')->get();
        return view('ecom.products.form', compact('categories', 'brands', 'allProducts'));
    }

    public function store(ProductRequest $request): JsonResponse {
        $data = $request->validated();
        $bundleProducts = $data['bundle_products'] ?? [];
        unset($data['bundle_products']);
        $product = $this->service->storeProduct($data, $bundleProducts);
        return $this->successJson('Product created!', $product, 201);
    }

    public function edit(Product $product) {
        $categories = Category::whereNull('parent_id')->with('children')->ordered()->get();
        $brands = Brand::active()->ordered()->get();
        $allProducts = Product::active()->where('id', '!=', $product->id)->orderBy('name')->get();
        return view('ecom.products.form', compact('product', 'categories', 'brands', 'allProducts'));
    }

    public function update(ProductRequest $request, Product $product): JsonResponse {
        $data = $request->validated();
        $bundleProducts = $data['bundle_products'] ?? [];
        unset($data['bundle_products']);
        $updated = $this->service->updateProduct($product->id, $data, $bundleProducts);
        return $this->successJson('Product updated!', $updated);
    }

    public function destroy(Product $product) {
        $this->service->deleteProduct($product->id);
        return redirect()->back()->with('success', 'Product deleted!');
    }

    public function toggleStatus(Request $request): JsonResponse {
        $request->validate(['status_id' => 'required|exists:products,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function toggleFeatured(Request $request): JsonResponse {
        $request->validate(['status_id' => 'required|exists:products,id']);
        $newStatus = $this->service->toggleFeatured($request->status_id);
        return $this->successJson('Featured updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse {
        $request->validate(['id' => 'required|exists:products,id', 'order_level' => 'required|integer|min:0']);
        $this->service->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order updated!');
    }

    public function deleteGalleryImage(Request $request): JsonResponse {
        $request->validate(['id' => 'required|integer', 'image' => 'required|string']);
        $this->service->deleteGalleryImage($request->id, $request->image);
        return response()->json(['status' => 200, 'msg' => 'Image deleted.']);
    }
}