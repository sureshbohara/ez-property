@extends('layouts.app')
@section('title', 'Availability Management')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Listing Management" subTitle="Availabilities" :breadcrumbItems="['Dashboard', 'Listings', 'Availabilities']" />

    <!-- ADD FORM -->
    <div class="card mb-4">
        <div class="card-header bg-custom text-white py-2"><h6 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Update Availability (Date Range)</h6></div>
        <div class="card-body bg-light p-3">
            <form id="addAvailabilityForm">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Select Listing</label>
                        <select name="listing_id" class="form-select" required>
                            <option value="">Choose a property...</option>
                            @foreach($listings as $listing)
                                <option value="{{ $listing->id }}">{{ $listing->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="blocked">🚫 Blocked</option>
                            <option value="booked">📅 Booked</option>
                            <option value="available">✅ Available</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Custom Price (Opt)</label>
                        <input type="number" step="0.01" name="custom_price" class="form-control" placeholder="Leave empty for default">
                    </div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-warning text-dark"><i class="bi bi-plus-circle"></i> Update Availability</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

 
    <div class="card">
        <div class="card-header bg-custom text-white py-2"><h6 class="mb-0"><i class="bi bi-table me-2"></i>Availability Calendar Data</h6></div>
        <div class="card-body bg-light p-3">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>Listing</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Custom Price</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($availabilities as $avail)
                            <tr>
                                <td><strong>{{ $avail->listing->title ?? 'N/A' }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($avail->date)->format('M d, Y') }}</td>
                                <td>
                                    <form class="avail-status-form" data-id="{{ $avail->id }}">
                                        @csrf
                                        <select name="status" class="form-select form-select-sm" style="width: 110px;">
                                            <option value="available" {{ $avail->status == 'available' ? 'selected' : '' }}>✅ Available</option>
                                            <option value="booked" {{ $avail->status == 'booked' ? 'selected' : '' }}>📅 Booked</option>
                                            <option value="blocked" {{ $avail->status == 'blocked' ? 'selected' : '' }}>🚫 Blocked</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    @if($avail->custom_price)
                                        <span class="text-success fw-bold">Rs. {{ number_format($avail->custom_price, 2) }}</span>
                                    @else
                                        <span class="text-muted">Default</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm delete-avail" data-id="{{ $avail->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No availability records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($availabilities->hasPages())
                <nav class="d-flex justify-content-end mt-3">{{ $availabilities->links() }}</nav>
            @endif
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#addAvailabilityForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST', url: "{{ route('listing.availabilities.store') }}",
                data: $(this).serialize(),
                success: (res) => { 
                    toastr.success(res.msg); 
                    setTimeout(() => location.reload(), 1000); 
                },
                error: (xhr) => {
                    let errors = xhr.responseJSON?.errors;
                    if(errors) { $.each(errors, (k, v) => toastr.error(v[0])); } 
                    else { toastr.error('Error updating availability'); }
                }
            });
        });
        $(document).on('change', '.avail-status-form select', function() {
            let form = $(this).closest('form');
            let newStatus = $(this).val();
            $.ajax({
                type: 'POST', url: "{{ route('listing.availabilities.status') }}",
                data: { id: form.data('id'), status: newStatus, _token: "{{ csrf_token() }}" },
                success: (res) => toastr.success(res.msg),
                error: () => { toastr.error('Failed to update status'); }
            });
        });
        $(document).on('click', '.delete-avail', function() {
            if(!confirm('Delete this availability record?')) return;
            let id = $(this).data('id');       
            let deleteUrl = "{{ route('listing.availabilities.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                type: 'DELETE', 
                url: deleteUrl,
                data: { _token: "{{ csrf_token() }}" },
                success: (res) => { 
                    toastr.success(res.msg); 
                    setTimeout(() => location.reload(), 1000); 
                },
                error: () => toastr.error('Failed to delete')
            });
        });
    });
</script>
@endpush