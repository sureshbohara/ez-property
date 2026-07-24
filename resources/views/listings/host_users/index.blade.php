@extends('layouts.app')
@section('title', 'Manage Users & Host Approvals')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Users" subTitle="Users & Host Requests" :breadcrumbItems="['Dashboard', 'Users']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-people me-2"></i> Users List</h6>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('listings.host_users.search')</div>
            <div class="row">@include('listings.host_users.table')</div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush