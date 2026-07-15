@extends('layouts.app')
@section('title', 'Pricing Rules')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Listing Management" subTitle="Pricing Rules" :breadcrumbItems="['Dashboard', 'Listings', 'Pricing Rules']" />


    <div class="card mb-4">
        <div class="card-header bg-custom text-white py-2">
            <h6 class="mb-0"><i class="bi bi-currency-exchange me-2"></i>Add New Pricing Rule</h6>
        </div>
        <div class="card-body bg-light p-3">
            <form id="addPricingRuleForm">
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
                        <label class="form-label fw-semibold">Price / Night</label>
                        <input type="number" step="0.01" name="price_per_night" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Min Nights</label>
                        <input type="number" name="minimum_nights" class="form-control" value="1" min="1">
                    </div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add Pricing Rule</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

  
    <div class="card">
        <div class="card-header bg-custom text-white py-2">
            <h6 class="mb-0"><i class="bi bi-table me-2"></i>Pricing Rules List</h6>
        </div>
        <div class="card-body bg-light p-3">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>Listing</th>
                            <th>Date Range</th>
                            <th>Price / Night</th>
                            <th>Min Nights</th>
                            <th width="100">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rules as $rule)
                            <tr>
                                <td><strong>{{ $rule->listing->title ?? 'N/A' }}</strong></td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ \Carbon\Carbon::parse($rule->start_date)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($rule->end_date)->format('M d, Y') }}
                                    </span>
                                </td>
                                <td><strong class="text-success">Rs. {{ number_format($rule->price_per_night, 2) }}</strong></td>
                                <td>{{ $rule->minimum_nights ?? 1 }} Nights</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm delete-rule" data-id="{{ $rule->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No pricing rules found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($rules->hasPages())
                <nav class="d-flex justify-content-end mt-3">{{ $rules->links() }}</nav>
            @endif
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#addPricingRuleForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST', 
                url: "{{ route('listing.pricing-rules.store') }}",
                data: $(this).serialize(),
                success: (res) => { 
                    toastr.success(res.msg); 
                    setTimeout(() => location.reload(), 1000); 
                },
                error: (xhr) => {
                    let errors = xhr.responseJSON?.errors;
                    if(errors) { 
                        $.each(errors, (k, v) => toastr.error(v[0])); 
                    } else { 
                        toastr.error('Error adding rule'); 
                    }
                }
            });
        });
        $(document).on('click', '.delete-rule', function() {
            if(!confirm('Are you sure you want to delete this pricing rule?')) return;
            let id = $(this).data('id');
            let deleteUrl = "{{ route('listing.pricing-rules.destroy', ':id') }}".replace(':id', id);
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