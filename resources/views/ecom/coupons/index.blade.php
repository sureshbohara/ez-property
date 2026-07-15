@extends('layouts.app')
@section('title', 'Coupons')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Coupons" subTitle="Coupon List" :breadcrumbItems="['Dashboard', 'E-Commerce', 'Coupons']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-ticket-perforated me-2"></i> Coupons</h6>
            <a href="{{ route('ecom.coupon.create') }}" class="btn btn-light btn-sm"><i class="bi bi-plus-lg"></i> Create New</a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('ecom.coupons.search')</div>
            <div class="row">@include('ecom.coupons.table')</div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("ecom.coupon.status") }}', 'Coupon status updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush