<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\CouponRequest;
use App\Services\Admin\CouponService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends BaseController
{
    public function __construct(protected CouponService $service) {
        $this->middleware('can:coupon.read')->only(['index']);
        $this->middleware('can:coupon.create')->only(['create', 'store']);
        $this->middleware('can:coupon.update')->only(['edit', 'update', 'toggleStatus']);
        $this->middleware('can:coupon.delete')->only('destroy');
    }

    public function index(Request $request) {
        $filters = $request->only('status', 'code', 'discount_type');
        return view('ecom.coupons.index', [
            'coupons' => $this->service->getCoupons($filters),
            'filters' => $filters,
        ]);
    }

    public function create() {
        return view('ecom.coupons.form');
    }

    public function store(CouponRequest $request): JsonResponse {
        $data = $request->validated();
        $coupon = $this->service->storeCoupon($data);
        return $this->successJson('Coupon created!', $coupon, 201);
    }

    public function edit(Coupon $coupon) {
        return view('ecom.coupons.form', compact('coupon'));
    }

    public function update(CouponRequest $request, Coupon $coupon): JsonResponse {
        $data = $request->validated();
        $updated = $this->service->updateCoupon($coupon->id, $data);
        return $this->successJson('Coupon updated!', $updated);
    }

    public function destroy(Coupon $coupon) {
        $this->service->deleteCoupon($coupon->id);
        return redirect()->back()->with('success', 'Coupon deleted!');
    }

    public function toggleStatus(Request $request): JsonResponse {
        $request->validate(['status_id' => 'required|exists:coupons,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }
}