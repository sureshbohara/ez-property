@extends('layouts.app')
@section('title', 'Manage Products')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Products" subTitle="Product List" :breadcrumbItems="['Dashboard', 'E-Commerce', 'Products']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-box-seam me-2"></i> Products</h6>
            <a href="{{ route('ecom.product.create') }}" class="btn btn-light btn-sm"><i class="bi bi-plus-lg"></i> Create New</a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('ecom.products.search')</div>
            <div class="row">@include('ecom.products.table')</div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("ecom.product.status") }}', 'Product status updated!');
        AdminCRUD.initOrderLevel('{{ route("ecom.product.order-level") }}', 'Product order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush