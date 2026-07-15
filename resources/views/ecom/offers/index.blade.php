@extends('layouts.app')
@section('title', 'Offers & Promotions')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Offers" subTitle="Promotions List" :breadcrumbItems="['Dashboard', 'E-Commerce', 'Offers']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-percent me-2"></i> Offers & Promotions</h6>
            <a href="{{ route('ecom.offer.create') }}" class="btn btn-light btn-sm"><i class="bi bi-plus-lg"></i> Create New</a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('ecom.offers.search')</div>
            <div class="row">@include('ecom.offers.table')</div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("ecom.offer.status") }}', 'Offer status updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush