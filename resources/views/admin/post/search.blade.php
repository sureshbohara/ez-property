<div class="col-12">
    <form id="filterForm" method="GET" class="row g-3 mb-3">
        <div class="col-md-6">
            <input type="text" name="title" id="searchInput" class="form-control form-control-sm" placeholder="🔍 Search by title..." value="{{ $filters['title'] ?? '' }}">
        </div>
        <div class="col-md-4">
            <select name="status" id="statusSelect" class="form-select form-select-sm">
                <option value="">All Status</option>
                <option value="active" {{ ($filters['status'] ?? '') == 'active' ? 'selected' : '' }}>✅ Active</option>
                <option value="inactive" {{ ($filters['status'] ?? '') == 'inactive' ? 'selected' : '' }}>❌ Inactive</option>
            </select>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.post.index') }}" class="btn btn-primary w-100 text-white btn-sm" title="Reset Filters"><i class="bi bi-x-circle"></i></a>
        </div>
    </form>
</div