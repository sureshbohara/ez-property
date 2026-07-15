@extends('layouts.app')
@section('title', 'Fixed Departures')
@section('content')

<main class="page-content">
    <x-breadcrumb title="Package Management" subTitle="Fixed Departures" :breadcrumbItems="['Dashboard', 'Packages', 'Departures']" />
    

    <div class="card mb-4">
        <div class="card-header bg-custom text-white py-2"><h6 class="mb-0">Add New Fixed Departure</h6></div>
        <div class="card-body bg-light p-3">
            <form id="addDepartureForm">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Package</label>
                        <select name="package_id" class="form-select" required>
                            <option value="">Select Package</option>
                            @foreach(\App\Models\Package::orderBy('name')->get() as $pkg)
                                <option value="{{ $pkg->id }}">{{ $pkg->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3"><label class="form-label">Start Date</label><input type="date" name="start_date" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">End Date</label><input type="date" name="end_date" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Discount Price</label><input type="number" step="0.01" name="discount_price" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Max Seats</label><input type="number" name="max_seats" class="form-control" required></div>
                    <div class="col-12"><label class="form-label">Description (Optional)</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                    <div class="col-12"><button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add Departure</button></div>
                </div>
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-header bg-custom text-white py-2"><h6 class="mb-0">Departure List</h6></div>
        <div class="card-body bg-light p-3">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>Package</th>
                            <th>Dates</th>
                            <th>Price</th>
                            <th>Seats</th>
                            <th width="100">Status</th>
                            <th width="80">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($getData as $dep)
                            <tr>
                                <td><strong>{{ $dep->package->name }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($dep->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($dep->end_date)->format('M d, Y') }}</td>
                                <td>${{ number_format($dep->discount_price, 2) }}</td>
                                <td><span class="badge bg-info">{{ $dep->booked_seats }}</span> / {{ $dep->max_seats }}</td>
                                <td>
                                    <form class="departure-status-form" data-id="{{ $dep->id }}">
                                        @csrf <input type="hidden" name="id" value="{{ $dep->id }}">
                                        <input type="checkbox" {{ $dep->status == 'active' ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm">
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('admin.delete.fix-depature-package', $dep->id) }}" method="POST" onsubmit="return confirm('Delete this departure?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">No departures found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($getData->hasPages())
                <nav class="d-flex justify-content-end mt-3">{{ $getData->links() }}</nav>
            @endif
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#addDepartureForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST', url: "{{ route('admin.fix-depature-package-add') }}",
                data: $(this).serialize(),
                success: (res) => { toastr.success(res.msg); setTimeout(() => location.reload(), 1000); },
                error: (xhr) => {
                    let errors = xhr.responseJSON?.errors;
                    if(errors) { $.each(errors, (k, v) => toastr.error(v[0])); } 
                    else { toastr.error(xhr.responseJSON?.msg || 'Error adding departure'); }
                }
            });
        });

        $(document).on('change', '.departure-status-form input[type="checkbox"]', function() {
            let form = $(this).closest('form');
            let isChecked = $(this).prop('checked');
            $.ajax({
                type: 'POST', url: "{{ route('admin.fix-depature-status') }}",
                data: { id: form.data('id'), status: isChecked ? 'active' : 'inactive', _token: "{{ csrf_token() }}" },
                success: (res) => toastr.success(res.msg),
                error: () => { toastr.error('Failed to update status'); $(this).prop('checked', !isChecked).change(); }
            });
        });
    });
</script>
@endpush