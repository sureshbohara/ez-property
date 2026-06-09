@extends('layouts.app')
@section('title', 'Manage FAQs')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage FAQs" subTitle="FAQ List" :breadcrumbItems="['Dashboard', 'FAQs']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">❓ FAQs</h6>
            <a href="{{ route('admin.faq.create') }}" class="btn btn-light btn-sm"><i class="bi bi-plus-lg"></i> Add FAQ</a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('admin.faq.search')</div>
            <div class="row">@include('admin.faq.table')</div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.faq.status") }}', 'FAQ status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.faq.order-level") }}', 'FAQ order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush