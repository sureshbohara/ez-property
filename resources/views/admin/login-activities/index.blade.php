@extends('layouts.app')

@section('title', 'Users Login Activity')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Users Login Activity" subTitle="Activity List" :breadcrumbItems="['Dashboard', 'Login Activities']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">🔐 Login Activities</h6>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-danger btn-sm" onclick="bulkDelete()">
                        <i class="bi bi-trash"></i> Delete Selected
                    </button>
                </div>
            </div>

        </div>
        
        <div class="card-body bg-light p-3">

            <div class="row mb-3">
                @include('admin.login-activities.search')
            </div>




            <div class="row">
                @include('admin.login-activities.table')
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
        $('#selectAll').on('change', function() {
            $('.row-checkbox').prop('checked', this.checked);
        });
    });

    function bulkDelete() {
        const ids = $('.row-checkbox:checked').map(function() {
            return this.value;
        }).get();

        if (ids.length === 0) {
            alert('Please select at least one record');
            return;
        }

        if (confirm(`Delete ${ids.length} selected activities?`)) {
            fetch("{{ route('admin.login-activities.bulk-delete') }}", {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ ids: ids })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) location.reload();
                else alert(data.message || 'Bulk delete failed');
            });
        }
    }
</script>
@endpush