@extends('layouts.app')

@section('title', isset($gallery) ? 'Edit Gallery Image' : 'Add Gallery Image')

@section('content')
<main class="page-content">
    <x-breadcrumb
        title="Manage Gallery"
        subTitle="{{ isset($gallery) ? 'Update Image' : 'Add New Image' }}"
        :breadcrumbItems="['Dashboard', 'Gallery']"
    />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-images me-2"></i>
                {{ isset($gallery) ? 'Update Gallery Image' : 'Add Gallery Image' }}
            </h6>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="galleryForm" method="POST" enctype="multipart/form-data"
                  action="{{ isset($gallery) ? route('admin.gallery.update', $gallery->id) : route('admin.gallery.store') }}">
                @csrf
                @if(isset($gallery)) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Image Details</h5>
                                <div class="row g-3">
                                    <x-input-field type="text" name="name" label="Image Name" :value="old('name', $gallery->name ?? '')" cols="col-12" required placeholder="e.g., Office Interior"/>
                                    
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Display On</label>
                                        <select name="display_on" class="form-select" required>
                                            <option value="default" {{ old('display_on', $gallery->display_on ?? '') == 'default' ? 'selected' : '' }}>🌐 Default/All Pages</option>
                                            <option value="homepage" {{ old('display_on', $gallery->display_on ?? '') == 'homepage' ? 'selected' : '' }}>🏠 Homepage</option>
                                            <option value="about" {{ old('display_on', $gallery->display_on ?? '') == 'about' ? 'selected' : '' }}>ℹ️ About Page</option>
                                            <option value="services" {{ old('display_on', $gallery->display_on ?? '') == 'services' ? 'selected' : '' }}>🔧 Services Page</option>
                                            <option value="contact" {{ old('display_on', $gallery->display_on ?? '') == 'contact' ? 'selected' : '' }}>📞 Contact Page</option>
                                        </select>
                                    </div>

                                    <x-input-field type="text" name="alt" label="Alt Text (SEO)" :value="old('alt', $gallery->alt ?? '')" cols="col-12" placeholder="e.g., Modern office interior design"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Settings</h5>
                                <div class="row g-3">
                                    <x-input-field type="number" name="order_level" label="Display Order" :value="old('order_level', $gallery->order_level ?? '0')" cols="col-12" min="0" placeholder="0 = Highest priority"/>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Gallery Image</label>
                                        <input type="file" name="image" class="form-control" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'imagePreview')" {{ isset($gallery) ? '' : 'required' }}>

                                    </div>

                                    <div class="col-12 text-center">
                                        <img src="{{ isset($gallery) && $gallery->image_url ? $gallery->image_url : asset('default/noimage.png') }}" alt="Preview" class="img-fluid preview-image border" id="imagePreview" style="max-height: 150px; width: auto; object-fit: cover;">
                                    </div>

                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2">
                                            <i class="bi bi-save me-2"></i> {{ isset($gallery) ? 'Update Image' : 'Add Image' }}
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
        $('#galleryForm').on('submit', function(e) {
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
                    setTimeout(() => { window.location.href = '{{ route("admin.gallery.index") }}'; }, 1500);
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