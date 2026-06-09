@extends('layouts.app')

@section('title', isset($post) ? 'Edit Post' : 'Create Post')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Posts" subTitle="{{ isset($post) ? 'Update Post' : 'Create Post' }}" :breadcrumbItems="['Dashboard', 'Posts']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>{{ isset($post) ? 'Update Post' : 'Create Post' }}</h6>
            <a href="{{ route('admin.post.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to List</a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="postForm" method="POST" enctype="multipart/form-data" action="{{ isset($post) ? route('admin.post.update', $post->id) : route('admin.post.store') }}">
                @csrf
                @if(isset($post)) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Post Content</h5>
                                <div class="row g-3">

                                    <x-input-field type="text" name="title" label="Post Title" :value="old('title', $post->title ?? '')" cols="col-12" required placeholder="e.g., How to start a blog" title="Enter the post title"/>
                                    
                                    <x-input-field type="textarea" name="excerpt" label="Short Excerpt" :value="old('excerpt', $post->excerpt ?? '')" cols="col-12" rows="2" placeholder="Brief summary shown in previews..." title="Short description"/>

                                    <x-input-field type="textarea" name="description" label="Full Post Content" :value="old('description', $post->description ?? '')" cols="col-12" rows="12" editor="true" placeholder="Write your full post content here..." title="Main content (supports HTML)"/>

                                    <div class="col-12"><hr class="my-2"><h6 class="text-muted mb-2"> SEO Settings</h6></div>

                                    <x-input-field type="text" name="meta_title" label="Meta Title" :value="old('meta_title', $post->meta_title ?? '')" cols="col-12" placeholder="SEO title"/>

                                    <x-input-field type="textarea" name="meta_description" label="Meta Description" :value="old('meta_description', $post->meta_description ?? '')" cols="col-12" rows="2" placeholder="Brief description for search engines..."/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">

                                <h5 class="card-title mb-3 border-bottom pb-2">Settings</h5>
                                <div class="row g-3">

                                    <div class="col-12">
                                        <label class="form-label fw-semibold" for="category_id">Category <span class="text-danger">*</span></label>
                                        <select name="category_id" id="category_id" class="form-select" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <x-input-field type="number" name="order_level" label="Display Order" :value="old('order_level', $post->order_level ?? '0')" cols="col-12" min="0" placeholder="0 = Highest priority"/>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold" for="image"> Post Featured Image</label>
                                        <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'imagePreview')">
                                        <small class="text-muted d-block mt-1">Recommended: 1200x630px</small>
                                    </div>

                                    <div class="col-12 text-center">
                                        <img src="{{ isset($post) && $post->image_url ? $post->image_url : asset('default/noimage.png') }}" alt="Post Preview" class="img-fluid preview-image border" id="imagePreview">
                                        <small class="text-muted d-block mt-1" id="imageHint">{{ isset($post) && $post->image ? '✓ Current image loaded' : 'No image selected' }}</small>
                                    </div>

                                    <div class="col-12"><hr class="my-2"><h6 class="text-muted mb-2"> Visibility </h6></div>

                                    <div class="col-12">
                                        <input type="hidden" name="is_featured" value="0">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">Featured Post</label>
                                        </div>
                                    </div>

                        

                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2"><i class="bi bi-save me-2"></i> {{ isset($post) ? 'Update Post' : 'Create Post' }}</button>
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
        $('#postForm').on('submit', function(e) {
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
                    setTimeout(() => { window.location.href = '{{ route("admin.post.index") }}'; }, 1500);
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