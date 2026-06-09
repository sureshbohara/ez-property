<div class="col-12">
    <form id="filterForm" method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="name" class="form-control form-control-sm"
                   placeholder="🔍 Search by name..." value="{{ old('name', $filters['name'] ?? '') }}">
        </div>
        <div class="col-md-3">
            <select name="display_on" class="form-select form-select-sm">
                <option value="">All Pages</option>
                <option value="default" {{ old('display_on', $filters['display_on'] ?? '') == 'default' ? 'selected' : '' }}>🌐 Default</option>
                <option value="homepage" {{ old('display_on', $filters['display_on'] ?? '') == 'homepage' ? 'selected' : '' }}>🏠 Homepage</option>
                <option value="about" {{ old('display_on', $filters['display_on'] ?? '') == 'about' ? 'selected' : '' }}>ℹ️ About</option>
                <option value="services" {{ old('display_on', $filters['display_on'] ?? '') == 'services' ? 'selected' : '' }}>🔧 Services</option>
                <option value="contact" {{ old('display_on', $filters['display_on'] ?? '') == 'contact' ? 'selected' : '' }}>📞 Contact</option>
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
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-primary w-100 text-white btn-sm">
                <i class="bi bi-x-circle"></i>
            </a>
        </div>
    </form>
</div>