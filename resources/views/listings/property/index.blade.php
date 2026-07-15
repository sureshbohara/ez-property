@extends('layouts.app')
@section('title', 'Manage Listings')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Listings" subTitle="Listing List" :breadcrumbItems="['Dashboard', 'Listings']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-house-door me-2"></i> Listings</h6>
            <a href="{{ route('listing.listing.create') }}" class="btn btn-light btn-sm"><i class="bi bi-plus-lg"></i> Create New</a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('listings.property.search')</div>
            <div class="row">@include('listings.property.table')</div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("listing.listing.status") }}', 'Listing status updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>

<script>
 $(document).ready(function() {
   $('.listing-type').change(function() {
    var listingId = $(this).data('type-id'); 
    var displayOn = $(this).val(); 
    $.ajax({
        url: '{{ route("listing.listing.type") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: listingId,
            display_on: displayOn 
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message || 'Display updated successfully!');
            } else {
                toastr.error('Failed to update Display.');
            }
        },
        error: function(xhr) {
            toastr.error('Error updating Display.');
        }
    });
});
});
</script>

@endpush