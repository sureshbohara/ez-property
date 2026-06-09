@extends('layouts.app')

@section('title', 'Manage Admin Users')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Admins" subTitle="Admin List" :breadcrumbItems="['Dashboard', 'Admins']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">👨‍💼 Admin Users</h6>
            <a href="{{ route('admin.user.create') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-lg"></i> Create New
            </a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('admin.user.search')</div>
            <div class="row">@include('admin.user.table')</div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.user.status") }}', 'Admin status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.user.order-level") }}', 'Admin order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush