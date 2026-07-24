<div class="col-12">
    <form id="filterForm" method="GET" class="row g-3 mb-3">
        <div class="col-md-5">
            <input type="text" name="name" class="form-control form-control-sm" placeholder="🔍 Search by name or email..." value="{{ $filters['name'] ?? '' }}">
        </div>
        <div class="col-md-3">
            <select name="role" class="form-select form-select-sm">
                <option value="">All Roles</option>
                <option value="admin" {{ ($filters['role'] ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="host" {{ ($filters['role'] ?? '') == 'host' ? 'selected' : '' }}>Host</option>
                <option value="guest" {{ ($filters['role'] ?? '') == 'guest' ? 'selected' : '' }}>Guest</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="host_status" class="form-select form-select-sm">
                <option value="">All Status</option>
                <option value="pending" {{ ($filters['host_status'] ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ ($filters['host_status'] ?? '') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ ($filters['host_status'] ?? '') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div class="col-md-2">
            <a href="{{ route('listing.host.index') }}" class="btn btn-primary w-100 text-white btn-sm"><i class="bi bi-x-circle"></i> Reset</a>
        </div>
    </form>
</div>