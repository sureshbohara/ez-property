<div class="col-12">
    <form id="filterForm" method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="name" class="form-control form-control-sm" placeholder="🔍 Search by offer name..." value="{{ $filters['name'] ?? '' }}">
        </div>
        <div class="col-md-3">
            <select name="offer_type" class="form-select form-select-sm">
                <option value="">All Types</option>
                <option value="buy_x_get_y_free" {{ ($filters['offer_type'] ?? '') == 'buy_x_get_y_free' ? 'selected' : '' }}>Buy X Get Y Free</option>
                <option value="percentage_discount" {{ ($filters['offer_type'] ?? '') == 'percentage_discount' ? 'selected' : '' }}>Percentage Discount</option>
                <option value="flat_discount" {{ ($filters['offer_type'] ?? '') == 'flat_discount' ? 'selected' : '' }}>Flat Discount</option>
                <option value="free_shipping" {{ ($filters['offer_type'] ?? '') == 'free_shipping' ? 'selected' : '' }}>Free Shipping</option>
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
            <a href="{{ route('ecom.offer.index') }}" class="btn btn-primary w-100 text-white btn-sm"><i class="bi bi-x-circle"></i></a>
        </div>
    </form>
</div>