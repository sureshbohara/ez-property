@extends('layouts.app')

@section('title', 'Update Profile')

@section('content')
<main class="page-content">
    <x-breadcrumb 
    :title="'Profile'" 
    :subTitle="'Update Profile'" 
    :breadcrumbItems="['Dashboard', 'Profile']" 
    />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-person-circle me-2"></i>
                Update Your Profile
            </h6>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="updateProfileForm" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row g-3">
                    
                   
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Personal Information</h5>
                                
                                <div class="row g-3">
                                    
                                   
                                    <x-input-field 
                                    type="text" 
                                    name="name" 
                                    label="Full Name" 
                                    :value="old('name', $admin->name ?? '')" 
                                    cols="col-12" 
                                    required 
                                    placeholder="e.g., John Doe"
                                    extraClass="text-capitalize"
                                    />

                                    
                                    <x-input-field 
                                    type="email" 
                                    name="email" 
                                    label="Email Address" 
                                    :value="old('email', $admin->email ?? '')" 
                                    cols="col-md-6" 
                                    required 
                                    placeholder="e.g., john@example.com"
                                    extraId="profileEmail"
                                    />

                                    
                                    <x-input-field 
                                    type="tel" 
                                    name="mobile" 
                                    label="Mobile Number" 
                                    :value="old('mobile', $admin->mobile ?? '')" 
                                    cols="col-md-6" 
                                    placeholder="e.g., +1 (555) 123-4567"
                                    pattern="[+0-9\s\-\(\)]+"
                                    />

                                    
                                    

                                    
                                    <x-input-field 
                                    type="textarea" 
                                    name="address" 
                                    label="Address" 
                                    :value="old('address', $admin->address ?? '')" 
                                    cols="col-12" 
                                    rows="2"
                                    placeholder="Street, City, State, ZIP Code"
                                    />

                                    
                                    <x-input-field 
                                    type="textarea" 
                                    name="details" 
                                    label="Details / Bio" 
                                    :value="old('details', $admin->details ?? '')" 
                                    cols="col-12" 
                                    rows="3"
                                    placeholder="Brief professional bio or notes about yourself..."
                                    />

                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Profile Settings</h5>
                                
                                <div class="row g-3">


                                  <x-input-field 
                                  type="select" 
                                  name="gender" 
                                  label="Gender" 
                                  :options="[
                                  '' => '-- Select Gender --',
                                  'male' => 'Male',
                                  'female' => 'Female',
                                  'other' => 'Other'
                                  ]" 
                                  :value="old('gender', $admin->gender ?? '')" 
                                  cols="col-md-12"
                                  />
                                  
                                  
                                  <div class="col-12">
                                    <label class="form-label fw-semibold">Profile Image</label>
                                    
                                    <input type="file" 
                                    name="image" 
                                    id="profileImageInput"
                                    class="form-control" 
                                    accept="image/png, image/jpeg, image/webp"
                                    onchange="previewImage(this, 'profileImagePreview')">
                                    
                                    <small class="text-muted d-block mt-1">
                                        <i class="bi bi-info-circle me-1"></i>
                                        PNG, JPG or WEBP. Max 2MB. Recommended: 400×400px
                                    </small>
                                </div>

                                
                                <div class="col-12 text-center">
                                    <img src="{{ $admin->image_url ?? asset('default/noimage.png') }}" 
                                    alt="Profile" 
                                    id="profileImagePreview" 
                                    class="img-fluid" style="max-height: 150px;">
                                </div>

                                
                                @if(isset($admin) && $admin->image)
                                <div class="col-12 text-center">
                                    <small class="text-muted">
                                        <i class="bi bi-check-circle text-success me-1"></i>
                                        Current image: {{ basename($admin->image) }}
                                    </small>
                                </div>
                                @endif

                                
                                <div class="col-12 mt-4 pt-2 border-top">
                                    <button type="submit" 
                                    id="profileSubmitBtn"
                                    class="btn btn-primary w-100 py-2">
                                    <i class="bi bi-save me-2"></i>
                                    Save Changes
                                </button>
                                <small class="text-muted d-block text-center mt-2">
                                    <i class="bi bi-shield-check me-1"></i>
                                    Changes are saved securely
                                </small>
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
    $('#updateProfileForm').submit(function(e){
        e.preventDefault();
        let form = $(this);
        form.find('.text-danger').remove();
        form.find('.is-invalid').removeClass('is-invalid');
        
        $.ajax({
            url: "{{ route('admin.profile.update') }}",
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: (res) => toastr.success(res.message),
            error: (xhr) => {
                if(xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, (field, err) => {
                        $(`[name="${field}"]`).addClass('is-invalid').after(`<span class="text-danger">${err[0]}</span>`);
                    });
                }
            }
        });
    });
</script>
@endpush
