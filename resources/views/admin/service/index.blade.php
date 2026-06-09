@extends('layouts.app')
@section('title', 'Manage Services')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Services" subTitle="Service List" :breadcrumbItems="['Dashboard', 'Services']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">⚙️ Service List</h6>
            <a href="{{ route('admin.service.create') }}" class="btn btn-light btn-sm"><i class="bi bi-plus-lg"></i> Create New</a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('admin.service.search')</div>
            <div class="row">@include('admin.service.table')</div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.service.status") }}', 'Service status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.service.order-level") }}', 'Service order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush