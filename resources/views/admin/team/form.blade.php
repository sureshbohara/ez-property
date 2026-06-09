@extends('layouts.app')

@section('title', isset($team) ? 'Edit Team Member' : 'Create Team Member')

@section('content')
<main class="page-content">
    <x-breadcrumb
    title="Manage Team"
    subTitle="{{ isset($team) ? 'Update Team Member' : 'Create Team Member' }}"
    :breadcrumbItems="['Dashboard', 'Team']"
    />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-people me-2"></i>
                {{ isset($team) ? 'Update Team Member' : 'Create Team Member' }}
            </h6>
            <a href="{{ route('admin.team.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="teamForm" method="POST" enctype="multipart/form-data"
            action="{{ isset($team) ? route('admin.team.update', $team->id) : route('admin.team.store') }}">
            @csrf
            @if(isset($team)) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-3 border-bottom pb-2">
                                Member Details
                            </h5>
                            <div class="row g-3">
                                <x-input-field 
                                type="text" 
                                name="name" 
                                label="Full Name" 
                                :value="old('name', $team->name ?? '')" 
                                cols="col-12" 
                                required 
                                placeholder="Enter full name (e.g., John Doe)"
                                title="Enter the team member's full name"/>

                                <x-input-field 
                                type="email" 
                                name="email" 
                                label="Email Address" 
                                :value="old('email', $team->email ?? '')" 
                                cols="col-md-6" 
                                placeholder="name@company.com"
                                title="Enter the team member's email address"/>

                                <x-input-field 
                                type="text" 
                                name="address" 
                                label="Location" 
                                :value="old('address', $team->address ?? '')" 
                                cols="col-md-6" 
                                placeholder="City, Country (e.g., New York, USA)"
                                title="Enter the team member's location or address"/>

                                <div class="col-12">
                                    <hr class="my-2">
                                    <h6 class="text-muted mb-3">
                                        <i class="bi bi-share me-2"></i>Social Media Links
                                    </h6>
                                </div>

                                <x-input-field 
                                type="url" 
                                name="facebook" 
                                label="Facebook" 
                                :value="old('facebook', $team->facebook ?? '')" 
                                cols="col-md-6" 
                                placeholder="https://facebook.com/username"
                                icon="bi-facebook"/>

                                <x-input-field 
                                type="url" 
                                name="instagram" 
                                label="Instagram" 
                                :value="old('instagram', $team->instagram ?? '')" 
                                cols="col-md-6" 
                                placeholder="https://instagram.com/username"
                                icon="bi-instagram"/>

                                <x-input-field 
                                type="url" 
                                name="youtube" 
                                label="YouTube" 
                                :value="old('youtube', $team->youtube ?? '')" 
                                cols="col-md-6" 
                                placeholder="https://youtube.com/@channelname"
                                icon="bi-youtube"/>

                                <x-input-field 
                                type="url" 
                                name="tiktok" 
                                label="TikTok" 
                                :value="old('tiktok', $team->tiktok ?? '')" 
                                cols="col-md-6" 
                                placeholder="https://tiktok.com/@username"
                                icon="bi-tiktok"/>

                                <x-input-field 
                                type="textarea" 
                                name="bio" 
                                label="Biography" 
                                :value="old('bio', $team->bio ?? '')" 
                                cols="col-12" 
                                rows="3" 
                                placeholder="Write a brief biography about the team member, their role, expertise, and achievements..."
                                title="Optional detailed biography (supports rich text formatting)"/>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-3 border-bottom pb-2">
                                Settings
                            </h5>
                            <div class="row g-3">
                                <x-input-field 
                                type="number" 
                                name="order_level" 
                                label="Display Order" 
                                :value="old('order_level', $team->order_level ?? '0')" 
                                cols="col-12" 
                                min="0" 
                                placeholder="0 (lowest number appears first)"
                                title="Lower numbers display first. Use 0 for top priority."/>

                                <div class="col-12">
                                    <label class="form-label fw-semibold" for="image">
                                       Profile Image
                                    </label>
                                    <input 
                                    type="file" 
                                    name="image" 
                                    id="image"
                                    class="form-control" 
                                    accept="image/png, image/jpeg, image/webp" 
                                    onchange="previewImage(this, 'imagePreview')"
                                    title="Upload profile image: JPG, PNG, or WebP format">
                                    <small class="text-muted d-block mt-1">
                                        <i class="bi bi-info-circle me-1"></i>Recommended: Square image, min 300x300px
                                    </small>
                                </div>

                                <div class="col-12 text-center">
                                    <img 
                                    src="{{ isset($team) && $team->image_url ? $team->image_url : asset('default/noimage.png') }}" 
                                    alt="Team Preview" 
                                    class="img-fluid preview-image border" 
                                    id="imagePreview" 
                                    style="max-height: 150px; width: 150px; object-fit: cover;">
                                    <small class="text-muted d-block mt-2" id="imageHint">
                                        {{ isset($team) && $team->image ? '✓ Current image loaded' : 'No image selected' }}
                                    </small>
                                </div>

                                <div class="col-12 mt-4 pt-2 border-top">
                                    <button type="submit" class="btn btn-primary w-100 py-2">
                                        <i class="bi bi-save me-2"></i> {{ isset($team) ? 'Update Member' : 'Create Member' }}
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
        $('#teamForm').on('submit', function(e) {
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
                    setTimeout(() => { window.location.href = '{{ route("admin.team.index") }}'; }, 1500);
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
</script>
@endpush