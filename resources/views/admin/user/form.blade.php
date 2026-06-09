@extends('layouts.app')

@section('title', isset($admin) ? 'Edit Admin' : 'Create Admin')

@section('content')
<main class="page-content">
    <x-breadcrumb
        title="Manage Admins"
        subTitle="{{ isset($admin) ? 'Update Admin' : 'Create Admin' }}"
        :breadcrumbItems="['Dashboard', 'Admins']"
    />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-person-badge me-2"></i>
                {{ isset($admin) ? 'Update Admin' : 'Create Admin' }}
            </h6>
            <a href="{{ route('admin.user.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
    
             <form id="adminForm" method="POST" enctype="multipart/form-data"
                  action="{{ isset($admin) ? route('admin.user.update', $admin->id) : route('admin.user.store') }}">
                @csrf
                @if(isset($admin))
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Admin Details</h5>
                                <div class="row g-3">

                                    <x-input-field 
                                        type="text" 
                                        name="name" 
                                        label="Full Name" 
                                        :value="old('name', $admin->name ?? '')" 
                                        cols="col-12" 
                                        required 
                                        placeholder="e.g., John Doe"
                                        title="Enter admin's full name"/>

                                    <x-input-field 
                                        type="email" 
                                        name="email" 
                                        label="Email Address" 
                                        :value="old('email', $admin->email ?? '')" 
                                        cols="col-md-6" 
                                        required 
                                        placeholder="admin@example.com"
                                        title="Enter valid email address"/>

                                    <x-input-field 
                                        type="text" 
                                        name="mobile" 
                                        label="Mobile Number" 
                                        :value="old('mobile', $admin->mobile ?? '')" 
                                        cols="col-md-6" 
                                        placeholder="+977-98XXXXXXXX"
                                        title="Optional contact number"/>

                                    <x-input-field 
                                        type="password" 
                                        name="password" 
                                        label="{{ isset($admin) ? 'New Password' : 'Password *' }}" 
                                        cols="col-md-6" 
                                        :required="!isset($admin)"
                                        placeholder="{{ isset($admin) ? 'Leave blank to keep current' : 'Min 8 characters' }}"
                                        title="{{ isset($admin) ? 'Enter new password or leave blank' : 'Create secure password' }}"/>

                                    <x-input-field 
                                        type="password" 
                                        name="password_confirmation" 
                                        label="Confirm Password" 
                                        cols="col-md-6" 
                                        :required="!isset($admin)"
                                        placeholder="Re-enter password"
                                        title="Must match password field"/>

                                    <x-input-field 
                                        type="text" 
                                        name="address" 
                                        label="Address" 
                                        :value="old('address', $admin->address ?? '')" 
                                        cols="col-12" 
                                        placeholder="Enter residential address"
                                        title="Optional address information"/>

                                    <x-input-field 
                                        type="textarea" 
                                        name="details" 
                                        label="Additional Details" 
                                        :value="old('details', $admin->details ?? '')" 
                                        cols="col-12" 
                                        rows="3"
                                        placeholder="Any additional notes or information..."
                                        title="Optional detailed description"/>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Settings</h5>
                                <div class="row g-3">

                                    <!-- Role -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold" for="role_id">User Role *</label>
                                        <select name="role_id" id="role_id" class="form-select" required>
                                            <option value="">-- Select Role --</option>
                                            @foreach($roles as $id => $name)
                                                <option value="{{ $id }}" 
                                                    {{ old('role_id', $admin->role_id ?? '') == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Gender as Select (not radio) -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold" for="gender">Gender</label>
                                        <select name="gender" id="gender" class="form-select">
                                            <option value="">-- Select Gender --</option>
                                            <option value="male" {{ old('gender', $admin->gender ?? '') == 'male' ? 'selected' : '' }}>👨 Male</option>
                                            <option value="female" {{ old('gender', $admin->gender ?? '') == 'female' ? 'selected' : '' }}>👩 Female</option>
                                            <option value="other" {{ old('gender', $admin->gender ?? '') == 'other' ? 'selected' : '' }}>⚪ Other</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Order Level -->
                                    <x-input-field 
                                        type="number" 
                                        name="order_level" 
                                        label="Display Order" 
                                        :value="old('order_level', $admin->order_level ?? '0')" 
                                        cols="col-12" 
                                        min="0" 
                                        placeholder="0 = Highest priority"
                                        title="Lower numbers display first"/>

                                 
                                    <div class="col-12">
                                        <label class="form-label fw-semibold" for="image">Profile Image</label>
                                        <input 
                                            type="file" 
                                            name="image" 
                                            id="image"
                                            class="form-control" 
                                            accept="image/png, image/jpeg, image/webp" 
                                            onchange="previewImage(this, 'imagePreview')"
                                            title="Upload profile image: JPG, PNG, or WebP">
                                    </div>

                                   
                                    <div class="col-12 text-center">
                                        <img 
                                            src="{{ isset($admin) && $admin->image_url ? $admin->image_url : asset('default/noimage.png') }}" 
                                            alt="Profile Preview" 
                                            class="img-fluid preview-image border" 
                                            id="imagePreview" 
                                            style="max-height: 150px; width: 150px; object-fit: cover;">
                                        <small class="text-muted d-block mt-1" id="imageHint">
                                            {{ isset($admin) && $admin->image ? 'Current image' : 'No image selected' }}
                                        </small>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2">
                                            <i class="bi bi-save me-2"></i> {{ isset($admin) ? 'Update Admin' : 'Create Admin' }}
                                        </button>
                                    </div>
                                    
                                </div>
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
    $(document).ready(function() {
        $('#adminForm').on('submit', function(e) {
            e.preventDefault();
            $('.text-danger').remove();
            $('.is-invalid').removeClass('is-invalid');
            
            const formData = new FormData(this);
            const url = $(this).attr('action');
            const submitBtn = $(this).find('button[type="submit"]');
            const originalBtnText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i> Processing...');
            
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    toastr.success(response.message);
                    setTimeout(() => { window.location.href = '{{ route("admin.user.index") }}'; }, 1500);
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html(originalBtnText);
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            const input = $('[name="' + field + '"]');
                            input.addClass('is-invalid').after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
                        });
                        toastr.error('Please fix the form errors');
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                    }
                }
            });
        });
    });

    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
                document.getElementById('imageHint').textContent = 'New image selected';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush