@extends('layouts.app')

@section('title', isset($banner) ? 'Edit Banner' : 'Create Banner')

@section('content')
<main class="page-content">
    <x-breadcrumb
        title="Manage Banners"
        subTitle="{{ isset($banner) ? 'Update Banner' : 'Create Banner' }}"
        :breadcrumbItems="['Dashboard', 'Banners']"
    />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-images me-2"></i>
                {{ isset($banner) ? 'Update Banner' : 'Create Banner' }}
            </h6>
            <a href="{{ route('admin.banner.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="bannerForm" method="POST" enctype="multipart/form-data"
                  action="{{ isset($banner) ? route('admin.banner.update', $banner->id) : route('admin.banner.store') }}">
                @csrf
                @if(isset($banner)) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Banner Content</h5>
                                <div class="row g-3">

                         
                                    <x-input-field 
                                        type="text" 
                                        name="title" 
                                        label="Title" 
                                        :value="old('title', $banner->title ?? '')" 
                                        cols="col-12" 
                                        required 
                                        placeholder="e.g., Summer Sale 2026"
                                        title="Enter a short, attention-grabbing headline"/>

                              
                                    <x-input-field 
                                        type="text" 
                                        name="subtitle" 
                                        label="Subtitle" 
                                        :value="old('subtitle', $banner->subtitle ?? '')" 
                                        cols="col-12" 
                                        placeholder="e.g., Up to 50% off selected items"
                                        title="Optional supporting text shown below the title"/>

                                
                                    <x-input-field 
                                        type="textarea" 
                                        name="description" 
                                        label="Description" 
                                        :value="old('description', $banner->description ?? '')" 
                                        cols="col-12" 
                                        rows="3" 
                                        editor="true" 
                                        placeholder="Add details, call-to-action, or promotional text..."
                                        title="Optional detailed content (supports rich text formatting)"/>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Settings</h5>
                                <div class="row g-3">

                                 
                                    <x-input-field 
                                        type="number" 
                                        name="order_level" 
                                        label="Display Order" 
                                        :value="old('order_level', $banner->order_level ?? '0')" 
                                        cols="col-12" 
                                        min="0" 
                                        placeholder="0 = Highest priority"
                                        title="Lower numbers display first. Use 0 for top priority."/>

                               
                                    <div class="col-12">
                                        <label class="form-label fw-semibold" for="image">Banner Image</label>
                                        <input 
                                            type="file" 
                                            name="image" 
                                            id="image"
                                            class="form-control" 
                                            accept="image/png, image/jpeg, image/webp" 
                                            onchange="previewImage(this, 'imagePreview')"
                                            title="Upload banner image: JPG, PNG, or WebP format">
                                       
                                    </div>

                             
                                    <div class="col-12 text-center">
                                        <img 
                                            src="{{ isset($banner) && $banner->image_url ? $banner->image_url : asset('default/noimage.png') }}" 
                                            alt="Banner Preview" 
                                            class="img-fluid preview-image border" 
                                            id="imagePreview" 
                                            style="max-height: 150px; width: auto; object-fit: cover;">
                                        <small class="text-muted d-block mt-1" id="imageHint">
                                            {{ isset($banner) && $banner->image ? 'Current image' : 'No image selected' }}
                                        </small>
                                    </div>

                                    {{-- Submit button --}}
                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2">
                                            <i class="bi bi-save me-2"></i> {{ isset($banner) ? 'Update Banner' : 'Create Banner' }}
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
        $('#bannerForm').on('submit', function(e) {
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
                    setTimeout(() => { window.location.href = '{{ route("admin.banner.index") }}'; }, 1500);
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