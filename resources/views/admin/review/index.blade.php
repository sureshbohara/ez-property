@extends('layouts.app')

@section('title', 'Manage Reviews')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Reviews" subTitle="Review List" :breadcrumbItems="['Dashboard', 'Reviews']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">⭐ Reviews</h6>
            <a href="{{ route('admin.review.create') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-lg"></i> Create New
            </a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('admin.review.search')</div>
            <div class="row">@include('admin.review.table')</div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.review.status") }}', 'Review status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.review.order-level") }}', 'Review order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush