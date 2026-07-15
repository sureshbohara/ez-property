<?php

namespace App\Services\Admin;

use App\Models\Coupon;

class CouponService
{
    public function __construct(protected Coupon $coupon) {}

    public function getCoupons(array $filters = []) {
        return $this->coupon->query()
            ->when(!empty($filters['status']), fn($q) => $q->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN)))
            ->when(!empty($filters['code']), fn($q) => $q->where('code', 'like', '%'.$filters['code'].'%'))
            ->when(!empty($filters['discount_type']), fn($q) => $q->where('discount_type', $filters['discount_type']))
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends($filters);
    }

    public function storeCoupon(array $data) {
        $data['code'] = strtoupper(trim($data['code']));
        return $this->coupon->create($data);
    }

    public function updateCoupon(int $id, array $data) {
        $coupon = $this->coupon->findOrFail($id);
        if (isset($data['code'])) $data['code'] = strtoupper(trim($data['code']));
        $coupon->update($data);
        return $coupon->fresh();
    }

    public function deleteCoupon(int $id): bool {
        return $this->coupon->findOrFail($id)->delete();
    }

    public function toggleStatus(int $id): bool {
        $coupon = $this->coupon->findOrFail($id);
        $coupon->status = !$coupon->status;
        $coupon->save();
        return $coupon->status;
    }
}