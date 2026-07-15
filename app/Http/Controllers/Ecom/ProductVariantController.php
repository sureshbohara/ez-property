<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\ProductVariantRequest;
use App\Services\Admin\ProductVariantService;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductAttribute;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductVariantController extends BaseController
{
    public function __construct(protected ProductVariantService $service) {
        $this->middleware('can:product.update');
    }

    public function index(Product $product) {
        $variants = $this->service->getVariants($product->id);
        $attributes = ProductAttribute::active()->ordered()->get();
        return view('ecom.products.variants', compact('product', 'variants', 'attributes'));
    }

    public function store(ProductVariantRequest $request, Product $product): JsonResponse {
        $data = $request->validated();
        $variant = $this->service->storeVariant($product->id, $data);
        return $this->successJson('Variant created!', $variant, 201);
    }

    public function update(ProductVariantRequest $request, ProductVariant $variant): JsonResponse {
        $data = $request->validated();
        $updated = $this->service->updateVariant($variant->id, $data);
        return $this->successJson('Variant updated!', $updated);
    }

    public function destroy(ProductVariant $variant): JsonResponse {
        $this->service->deleteVariant($variant->id);
        return $this->successJson('Variant deleted!');
    }
}