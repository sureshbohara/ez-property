@extends('layouts.app')
@section('title', 'System Permission')

@section('content')
<main class="page-content">
    <x-breadcrumb title="System Permission" subTitle="Permission List" :breadcrumbItems="['Dashboard', 'Permission']" />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">🔐 System Permissions</h6>
            @if(auth('admin')->user()->hasPermission('permission', 'create'))
            <a href="{{ route('admin.permission.create') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-lg"></i> Create New
            </a>
            @endif
        </div>
        <div class="card-body bg-light p-3">
            <div class="row">@include('admin.permissions.table')</div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Permission list JS if needed
    });
</script>
@endpush