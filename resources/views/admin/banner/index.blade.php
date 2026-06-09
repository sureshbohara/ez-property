@extends('layouts.app')

@section('title', 'Manage Banners')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Banners" subTitle="Banner List" :breadcrumbItems="['Dashboard', 'Banners']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">🖼️ Banners</h6>
            <a href="{{ route('admin.banner.create') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-lg"></i> Create New
            </a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('admin.banner.search')</div>
            <div class="row">@include('admin.banner.table')</div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.banner.status") }}', 'Banner status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.banner.order-level") }}', 'Banner order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush