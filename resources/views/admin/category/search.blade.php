<div class="col-12">
    <form id="filterForm" method="GET" class="row g-3 mb-3">

        <div class="col-md-3">
            <input type="text" name="name" class="form-control form-control-sm" placeholder="🔍 Search by name..." value="{{ old('name', $filters['name'] ?? '') }}">
        </div>

        <div class="col-md-3">
            <select name="parent_id" class="form-select form-select-sm">
                <option value="">All Parents</option>
                @foreach($parentCategories as $p) <option value="{{ $p->id }}" {{ old('parent_id', $filters['parent_id'] ?? '') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option> @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="display_on" class="form-select form-select-sm">
                <option value="">All Pages</option>
                <option value="default" {{ old('display_on', $filters['display_on'] ?? '') == 'default' ? 'selected' : '' }}> Default</option>
                <option value="header" {{ old('display_on', $filters['display_on'] ?? '') == 'header' ? 'selected' : '' }}> Header</option>
                <option value="footer" {{ old('display_on', $filters['display_on'] ?? '') == 'footer' ? 'selected' : '' }}> Footer</option>
            </select>
        </div>

        <div class="col-md-2">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Status</option>
                <option value="1" {{ old('status', $filters['status'] ?? '') == '1' ? 'selected' : '' }}>✅ Active</option>
                <option value="0" {{ old('status', $filters['status'] ?? '') == '0' ? 'selected' : '' }}>❌ Inactive</option>
            </select>
        </div>

        <div class="col-md-2 d-flex gap-2">
            <a href="{{ route('admin.category.index') }}" class="btn btn-primary btn-sm text-white">✕ Reset</a>
        </div>
    </form>
</div>