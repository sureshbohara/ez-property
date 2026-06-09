@extends('layouts.app')

@section('title', 'Manage Posts')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Posts" subTitle="Post List" :breadcrumbItems="['Dashboard', 'Posts']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">📝 Posts</h6>
            <a href="{{ route('admin.post.create') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-lg"></i> Create New
            </a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('admin.post.search')</div>
            <div class="row">@include('admin.post.table')</div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.post.status") }}', 'Post status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.post.order-level") }}', 'Post order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
        $('.featured-toggle').on('change', function() {
            let id = $(this).data('id');
            let $this = $(this);
            $.ajax({
                url: '{{ route("admin.post.featured") }}',
                type: 'POST',
                data: { id: id, _token: '{{ csrf_token() }}' },
                success: function(res) {
                    toastr.success(res.message);
                },
                error: function() {
                    toastr.error('Failed to update featured status');
                    $this.prop('checked', !$this.prop('checked'));
                }
            });
        });
    });
</script>
@endpush