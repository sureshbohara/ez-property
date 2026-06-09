@extends('layouts.app')

@section('title', 'Manage Team')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Team" subTitle="Team List" :breadcrumbItems="['Dashboard', 'Team']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">👥 Team Members</h6>
            <a href="{{ route('admin.team.create') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-lg"></i> Create New
            </a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('admin.team.search')</div>
            <div class="row">@include('admin.team.table')</div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.team.status") }}', 'Team status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.team.order-level") }}', 'Team order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush