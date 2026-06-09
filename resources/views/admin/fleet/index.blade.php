@extends('layouts.app')
@section('title', 'Manage Fleets')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Fleets" subTitle="Fleet List" :breadcrumbItems="['Dashboard', 'Fleets']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">🚗 Fleets List</h6>
            <a href="{{ route('admin.fleet.create') }}" class="btn btn-light btn-sm"><i class="bi bi-plus-lg"></i> Create New</a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('admin.fleet.search')</div>
            <div class="row">@include('admin.fleet.table')</div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.fleet.status") }}', 'Fleet status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.fleet.order-level") }}', 'Fleet order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush