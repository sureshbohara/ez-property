@extends('layouts.app')
@section('title', 'Manage Categories')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Categories" subTitle="Category List" :breadcrumbItems="['Dashboard', 'Categories']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">📂 Categories</h6>
            <a href="{{ route('admin.category.create') }}" class="btn btn-light btn-sm"><i class="bi bi-plus-lg"></i> Create New</a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('admin.category.search')</div>
            <div class="row">@include('admin.category.table')</div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.category.status") }}', 'Category status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.category.order-level") }}', 'Category order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush