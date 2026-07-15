<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\BrandRequest;
use App\Services\Admin\BrandService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends BaseController
{
    public function __construct(protected BrandService $service) {
        $this->middleware('can:brand.read')->only(['index']);
        $this->middleware('can:brand.create')->only(['create', 'store']);
        $this->middleware('can:brand.update')->only(['edit', 'update', 'toggleStatus', 'updateOrderLevel']);
        $this->middleware('can:brand.delete')->only('destroy');
    }

    public function index(Request $request) {
        $filters = $request->only('status', 'name');
        return view('ecom.brands.index', [
            'brands' => $this->service->getBrands($filters),
            'filters' => $filters,
        ]);
    }

    public function create() {
        return view('ecom.brands.form');
    }

    public function store(BrandRequest $request): JsonResponse {
        $data = $request->validated();
        $brand = $this->service->storeBrand($data);
        return $this->successJson('Brand created!', $brand, 201);
    }

    public function edit(Brand $brand) {
        return view('ecom.brands.form', compact('brand'));
    }

    public function update(BrandRequest $request, Brand $brand): JsonResponse {
        $data = $request->validated();
        $updated = $this->service->updateBrand($brand->id, $data);
        return $this->successJson('Brand updated!', $updated);
    }

    public function destroy(Brand $brand) {
        $this->service->deleteBrand($brand->id);
        return redirect()->back()->with('success', 'Brand deleted!');
    }

    public function toggleStatus(Request $request): JsonResponse {
        $request->validate(['status_id' => 'required|exists:brands,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse {
        $request->validate(['id' => 'required|exists:brands,id', 'order_level' => 'required|integer|min:0']);
        $this->service->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order updated!');
    }
}