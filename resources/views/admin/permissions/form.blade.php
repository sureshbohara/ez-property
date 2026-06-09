@extends('layouts.app')
@section('title', isset($permission) ? 'Edit Permission' : 'Create Permission')

@section('content')
<main class="page-content">
    <x-breadcrumb title="System Permission" subTitle="Permission {{ isset($permission) ? 'Update' : 'Create' }}" :breadcrumbItems="['Dashboard', 'Permission']" />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-shield-lock me-2"></i>
                {{ isset($permission) ? 'Update System Permission' : 'Create System Permission' }}
            </h6>
            <a href="{{ route('admin.permission.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            @php $actionIcons = ['read' => '🔍', 'create' => '🛠️', 'update' => '⚙️', 'delete' => '🚫']; @endphp
            
            <form id="permissionForm" method="POST" data-permission-id="{{ $permission->id ?? '' }}">
                @csrf 
                @if(isset($permission)) @method('PUT') @endif
                
                <div class="row g-3">
                    <div class="col-lg-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Role Selection</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Select Role <span class="text-danger">*</span></label>
                                        <select name="role_id" class="form-select" {{ isset($permission) ? 'disabled' : '' }} required>
                                            <option value="">--- Select Role ---</option>
                                            @foreach($roles as $role)
                                            <option value="{{ $role->id }}" 
                                                {{ (isset($permission) && $permission->role_id == $role->id) || old('role_id') == $role->id ? 'selected' : '' }} 
                                                {{ $role->name === 'super_admin' ? 'disabled' : '' }}>
                                                {{ $role->display_name ?? $role->name }} 
                                                @if($role->name === 'super_admin') <span class="text-warning">(Protected)</span> @endif
                                            </option>
                                            @endforeach
                                        </select>
                                        @if(isset($permission)) 
                                            <input type="hidden" name="role_id" value="{{ $permission->role_id }}"> 
                                        @endif
                                        @error('role_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Permission Matrix</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="40%" class="bg-light">
                                                    📦 Entity | 
                                                    <input type="checkbox" id="master" class="form-check-input" title="Select/Deselect All">
                                                </th>
                                                @foreach($actions as $action) 
                                                <th class="text-center bg-light" title="{{ ucfirst($action) }}">
                                                    {{ $actionIcons[$action] }}<br>
                                                    <small class="text-uppercase fw-semibold">{{ $action }}</small>
                                                </th> 
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($entities as $entity)
                                            <tr>
                                                <th scope="row" class="bg-light">
                                                    <div class="d-flex align-items-center">
                                                        <input type="checkbox" 
                                                            class="form-check-input entity-master me-2" 
                                                            data-entity="{{ $entity }}" 
                                                            {{ isset($defaultPermissions[$entity]) && collect($defaultPermissions[$entity])->filter(fn($v) => $v === '1')->count() === 4 ? 'checked' : '' }}
                                                            title="Toggle all {{ $entity }} permissions">
                                                        <span class="fw-semibold text-capitalize">{{ $entity }}</span>
                                                    </div>
                                                </th>
                                                @foreach($actions as $action)
                                                <td class="text-center">
                                                    <input type="checkbox" 
                                                        class="form-check-input sub_check" 
                                                        name="permission[{{ $entity }}][{{ $action }}]" 
                                                        value="1" 
                                                        data-entity="{{ $entity }}" 
                                                        data-action="{{ $action }}" 
                                                        {{ (isset($defaultPermissions[$entity][$action]) && $defaultPermissions[$entity][$action] === '1') || old("permission.{$entity}.{$action}") ? 'checked' : '' }} 
                                                        {{ (isset($permission) && $permission->role?->name === 'super_admin') ? 'disabled checked' : '' }}
                                                        title="{{ ucfirst($action) }} {{ $entity }}">
                                                </td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @error('permission') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="submit" class="btn btn-primary text-white" id="submitBtn">
                                <i class="bi bi-save me-1"></i> {{ isset($permission) ? 'Update Permission' : 'Create Permission' }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    
    // Master checkbox - select/deselect all
    $('#master').on('change', function () {
        $('.sub_check:enabled').prop('checked', this.checked);
        $('.entity-master').prop('checked', this.checked);
    });

    // Entity master checkbox
    $('.entity-master').on('change', function () {
        const entity = $(this).data('entity');
        $(`.sub_check[data-entity="${entity}"]:enabled`).prop('checked', $(this).prop('checked'));
        updateMaster();
    });

    // Individual checkbox handler
    $('.sub_check').on('change', function () {
        const entity = $(this).data('entity');
        const all = $(`.sub_check[data-entity="${entity}"]:enabled`);
        $(`.entity-master[data-entity="${entity}"]`).prop('checked', all.length === all.filter(':checked').length);
        updateMaster();
    });

    // Update main master checkbox state
    function updateMaster() {
        const all = $('.sub_check:enabled');
        $('#master').prop('checked', all.length === all.filter(':checked').length);
    }
    updateMaster();

    // AJAX Form Submit
    $('#permissionForm').on('submit', function (e) {
        e.preventDefault();
        $('.text-danger').remove();
        $('.is-invalid').removeClass('is-invalid');

        const formData = new FormData(this);
        const permissionId = $(this).data('permission-id');
        const url = permissionId
            ? "{{ route('admin.permission.update', ':id') }}".replace(':id', permissionId)
            : "{{ route('admin.permission.store') }}";
        const btn = $('#submitBtn');
        const originalBtnText = btn.html();

        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i> Processing...');

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (response) {
                toastr.success(response.message);
                setTimeout(() => { window.location.href = '{{ route("admin.permission.index") }}'; }, 1500);
            },
            error: function (xhr) {
                btn.prop('disabled', false).html(originalBtnText);
                if (xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function (field, errors) {
                        if (field.startsWith('permission.')) {
                            $('.table').after(`<span class="text-danger small">${errors[0]}</span>`);
                        } else {
                            $(`[name="${field}"]`).addClass('is-invalid').after(`<div class="invalid-feedback d-block">${errors[0]}</div>`);
                        }
                    });
                    toastr.error('Please fix the form errors');
                } else {
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                }
            }
        });
    });
});
</script>
@endpush