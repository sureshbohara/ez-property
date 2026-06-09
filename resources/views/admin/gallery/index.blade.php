@extends('layouts.app')

@section('title', 'Manage Gallery')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Gallery" subTitle="Gallery Images" :breadcrumbItems="['Dashboard', 'Gallery']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">🖼️ Gallery</h6>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-lg"></i> Add Image
            </a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('admin.gallery.search')</div>
            <div class="row">@include('admin.gallery.table')</div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.gallery.status") }}', 'Gallery status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.gallery.order-level") }}', 'Gallery order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush