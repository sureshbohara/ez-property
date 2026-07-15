<div class="col-12">
    <form id="filterForm" method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="name" class="form-control form-control-sm" placeholder="🔍 Search by name/SKU..." value="{{ $filters['name'] ?? '' }}">
        </div>
        <div class="col-md-2">
            <select name="product_type" class="form-select form-select-sm">
                <option value="">All Types</option>
                <option value="simple" {{ ($filters['product_type'] ?? '') == 'simple' ? 'selected' : '' }}>Simple</option>
                <option value="variable" {{ ($filters['product_type'] ?? '') == 'variable' ? 'selected' : '' }}>Variable</option>
                <option value="grouped" {{ ($filters['product_type'] ?? '') == 'grouped' ? 'selected' : '' }}>Grouped</option>
                <option value="digital" {{ ($filters['product_type'] ?? '') == 'digital' ? 'selected' : '' }}>Digital</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="brand_id" class="form-select form-select-sm">
                <option value="">All Brands</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ ($filters['brand_id'] ?? '') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Status</option>
                <option value="1" {{ ($filters['status'] ?? '') == '1' ? 'selected' : '' }}>✅ Active</option>
                <option value="0" {{ ($filters['status'] ?? '') == '0' ? 'selected' : '' }}>❌ Inactive</option>
            </select>
        </div>
        <div class="col-md-2">
            <a href="{{ route('ecom.product.index') }}" class="btn btn-primary w-100 text-white btn-sm"><i class="bi bi-x-circle"></i></a>
        </div>
    </form>
</div>