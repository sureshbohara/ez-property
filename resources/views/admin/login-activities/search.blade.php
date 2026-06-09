<div class="col-12">
    <form id="filterForm" method="GET" action="{{ route('admin.login-activities.index') }}" class="row g-2 align-items-end">
        
        <!-- Search by User/IP -->
        <div class="col-md-3">
            <label class="form-label small text-muted">Search</label>
            <input type="text" name="search" class="form-control form-control-sm" 
                   placeholder="User, Email, IP..." value="{{ request('search') }}">
        </div>

        <!-- Date From -->
        <div class="col-md-2">
            <label class="form-label small text-muted">From Date</label>
            <input type="date" name="from_date" class="form-control form-control-sm" 
                   value="{{ request('from_date') }}">
        </div>

        <!-- Date To -->
        <div class="col-md-2">
            <label class="form-label small text-muted">To Date</label>
            <input type="date" name="to_date" class="form-control form-control-sm" 
                   value="{{ request('to_date') }}">
        </div>

        <!-- Device Type Filter -->
        <div class="col-md-2">
            <label class="form-label small text-muted">Device</label>
            <select name="device_type" class="form-select form-select-sm">
                <option value="">All Devices</option>
                <option value="desktop" {{ request('device_type')=='desktop'?'selected':'' }}>Desktop</option>
                <option value="mobile" {{ request('device_type')=='mobile'?'selected':'' }}>Mobile</option>
                <option value="tablet" {{ request('device_type')=='tablet'?'selected':'' }}>Tablet</option>
            </select>
        </div>

        <!-- Per Page -->
        <div class="col-md-2">
            <label class="form-label small text-muted">Per Page</label>
            <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="10" {{ request('per_page')==10?'selected':'' }}>10</option>
                <option value="25" {{ request('per_page')==25?'selected':'' }}>25</option>
                <option value="50" {{ request('per_page')==50?'selected':'' }}>50</option>
                <option value="100" {{ request('per_page')==100?'selected':'' }}>100</option>
            </select>
        </div>

        <!-- Actions -->
        <div class="col-md-1 d-flex gap-2">
            <a href="{{ route('admin.login-activities.index') }}" class="btn btn-primary btn-sm text-white" title="Reset">
                <i class="bi bi-x-lg"></i>
            </a>
        </div>
    </form>
</div>