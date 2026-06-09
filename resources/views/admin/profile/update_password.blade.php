@extends('layouts.app')

@section('title', 'Update Password')

@section('content')
<main class="page-content">
    <x-breadcrumb 
        :title="'Profile'" 
        :subTitle="'Update Password'" 
        :breadcrumbItems="['Dashboard', 'Password']" 
    />
    
    <div class="card mb-4">
        <div class="card-header bg-custom text-white">
            <h6 class="mb-0">Update Your Password</h6>
        </div>
        
        <div class="card-body bg-light p-3">
            <form id="updatePassword" method="POST">
                @csrf
                
                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="card shadow-sm shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Password Fields</h6>
                                
                              
                                <x-input-field 
                                    type="password" 
                                    name="current_password" 
                                    label="Current Password" 
                                    cols="col-12" 
                                    required 
                                    placeholder="Enter your current password"
                                />

                         
                                <x-input-field 
                                    type="password" 
                                    name="password" 
                                    label="New Password" 
                                    cols="col-12" 
                                    required 
                                    placeholder="Minimum 8 characters"
                                />

                 
                                <x-input-field 
                                    type="password" 
                                    name="password_confirmation" 
                                    label="Confirm Password" 
                                    cols="col-12" 
                                    required 
                                    placeholder="Re-enter new password"
                                />

                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-save me-2"></i>Save & Update
                                    </button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card shadow-sm shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="mb-3">
                                    <i class="bi bi-key me-2"></i>Password Requirements
                                </h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        🔑 Enter your <strong>current password</strong>
                                    </li>
                                    <li class="list-group-item">
                                        🆕 New password must be at least <strong>8 characters</strong>
                                    </li>
                                    <li class="list-group-item">
                                        🔄 Must include letters and numbers
                                    </li>
                                    <li class="list-group-item">
                                        ✅ Confirm by re-typing the new password
                                    </li>
                                    <li class="list-group-item">
                                        ⚠️ New password must be different from current
                                    </li>
                                </ul>
                            </div>
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
$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $('#updatePassword').on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        let submitBtn = form.find('button[type="submit"]');

        form.find('.text-danger').remove();
        form.find('.is-invalid').removeClass('is-invalid');
        submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-2"></i>Updating...');

        $.ajax({
            url: "{{ route('admin.password.update') }}",
            type: 'POST',
            data: form.serialize(),
            success: function(res) {
                if (res.success) {
                    toastr.success(res.message);
                    form[0].reset(); 
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {

                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        let input = $('[name="'+field+'"]');
                        input.addClass('is-invalid');
                        input.after('<span class="text-danger">'+messages[0]+'</span>');
                    });
                } else {
                    toastr.error('Something went wrong. Please try again.');
                }
            },
            complete: function() {

                submitBtn.prop('disabled', false).html('<i class="bi bi-save me-2"></i>Save & Update');
            }
        });
    });
});
</script>
@endpush
