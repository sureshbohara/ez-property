<div class="row mb-3">
    <div class="col-12">
        <form id="filterForm" method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control form-control-sm" 
                       placeholder="🔍 Search menu name..." 
                       value="{{ old('name', $filters['name'] ?? '') }}">
            </div>
            <div class="col-md-3">
                <select name="location" class="form-select form-select-sm">
                    <option value="">All Locations</option>
                    @foreach(\App\Models\Menu::LOCATIONS as $key => $label)
                        <option value="{{ $key }}" {{ old('location', $filters['location'] ?? '') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="1" {{ old('status', $filters['status'] ?? '') == '1' ? 'selected' : '' }}>✅ Active</option>
                    <option value="0" {{ old('status', $filters['status'] ?? '') == '0' ? 'selected' : '' }}>❌ Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.menu.index') }}" class="btn btn-primary text-white w-100 btn-sm">
                    <i class="bi bi-x-circle me-1"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>