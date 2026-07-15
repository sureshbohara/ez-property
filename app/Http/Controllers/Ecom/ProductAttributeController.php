<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\ProductAttributeRequest;
use App\Services\Admin\ProductAttributeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;

class ProductAttributeController extends BaseController
{
    
    public function __construct(protected ProductAttributeService $service) {    
        $this->middleware('can:product.read')->only(['index']);
        $this->middleware('can:product.create')->only(['create', 'store']);
        $this->middleware('can:product.update')->only(['edit', 'update', 'toggleStatus', 'updateOrderLevel']);
        $this->middleware('can:product.delete')->only('destroy');
    }

    public function index(Request $request) {
        $filters = $request->only('status', 'name');
        return view('ecom.product-attributes.index', [
            'attributes' => $this->service->getAttributes($filters),
            'filters' => $filters,
        ]);
    }

    public function create() {
        return view('ecom.product-attributes.form');
    }

    public function store(ProductAttributeRequest $request): JsonResponse {
        $data = $request->validated();        
        $attribute = $this->service->storeAttribute($data);
        return $this->successJson('Attribute created!', $attribute, 201);
    }

    public function edit(ProductAttribute $productAttribute) {
        return view('ecom.product-attributes.form', compact('productAttribute'));
    }

    public function update(ProductAttributeRequest $request, ProductAttribute $productAttribute): JsonResponse {
        $data = $request->validated();
        $updated = $this->service->updateAttribute($productAttribute->id, $data);
        return $this->successJson('Attribute updated!', $updated);
    }

    public function destroy(ProductAttribute $productAttribute) {
        $this->service->deleteAttribute($productAttribute->id);
        return redirect()->back()->with('success', 'Attribute deleted!');
    }

    public function toggleStatus(Request $request): JsonResponse {
        $request->validate(['status_id' => 'required|exists:product_attributes,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse {
        $request->validate(['id' => 'required|exists:product_attributes,id', 'order_level' => 'required|integer|min:0']);
        $this->service->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order updated!');
    }
}