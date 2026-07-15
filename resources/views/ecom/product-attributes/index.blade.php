@extends('layouts.app')
@section('title', 'Product Attributes')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Product Attributes" subTitle="Attribute List" :breadcrumbItems="['Dashboard', 'E-Commerce', 'Attributes']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-sliders me-2"></i> Product Attributes</h6>
            <a href="{{ route('ecom.product-attribute.create') }}" class="btn btn-light btn-sm"><i class="bi bi-plus-lg"></i> Create New</a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('ecom.product-attributes.search')</div>
            <div class="row">@include('ecom.product-attributes.table')</div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("ecom.product-attribute.status") }}', 'Attribute status updated!');
        AdminCRUD.initOrderLevel('{{ route("ecom.product-attribute.order-level") }}', 'Attribute order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush