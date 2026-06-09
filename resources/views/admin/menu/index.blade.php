@extends('layouts.app')
@section('title', 'Manage Menus')
@section('content')
<main class="page-content">
    <div class="container-fluid">
        <x-breadcrumb title="Manage Menus" subTitle="Menu List" :breadcrumbItems="['Dashboard', 'Menus']"/>
        
  

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-custom text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Menus</h5>
                        <a href="{{ route('admin.menu.create') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-plus-lg me-1"></i>Add Menu
                        </a>
                    </div>
                    <div class="card-body">
                        @include('admin.menu.search')
                        @include('admin.menu.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        if(typeof AdminCRUD !== 'undefined') {
            AdminCRUD.initStatusToggle('{{ route("admin.menu.status") }}', 'Menu status updated!');
            AdminCRUD.initOrderLevel('{{ route("admin.menu.order-level") }}', 'Menu order updated!');
            AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
        }
    });
</script>
@endpush