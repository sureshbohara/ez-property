<div class="col-12">
    <form id="filterForm" method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="code" class="form-control form-control-sm" placeholder="🔍 Search by coupon code..." value="{{ $filters['code'] ?? '' }}">
        </div>
        <div class="col-md-3">
            <select name="discount_type" class="form-select form-select-sm">
                <option value="">All Types</option>
                <option value="fixed" {{ ($filters['discount_type'] ?? '') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                <option value="percentage" {{ ($filters['discount_type'] ?? '') == 'percentage' ? 'selected' : '' }}>Percentage</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Status</option>
                <option value="1" {{ ($filters['status'] ?? '') == '1' ? 'selected' : '' }}>✅ Active</option>
                <option value="0" {{ ($filters['status'] ?? '') == '0' ? 'selected' : '' }}>❌ Inactive</option>
            </select>
        </div>
        <div class="col-md-2">
            <a href="{{ route('ecom.coupon.index') }}" class="btn btn-primary w-100 text-white btn-sm"><i class="bi bi-x-circle"></i></a>
        </div>
    </form>
</div>