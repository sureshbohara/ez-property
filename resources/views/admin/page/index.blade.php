@extends('layouts.app')

@section('title', 'Manage Pages')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Pages" subTitle="Page List" :breadcrumbItems="['Dashboard', 'Pages']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">📄 Pages</h6>
            <a href="{{ route('admin.page.create') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-lg"></i> Create New
            </a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('admin.page.search')</div>
            <div class="row">@include('admin.page.table')</div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.page.status") }}', 'Page status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.page.order-level") }}', 'Page order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush