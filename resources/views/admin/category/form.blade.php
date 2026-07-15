@extends('layouts.app')
@section('title', isset($category) ? 'Edit Category' : 'Create Category')

@section('content')
<main class="page-content">
    <x-breadcrumb 
    title="Manage Categories" 
    subTitle="{{ isset($category) ? 'Update Category' : 'Create Category' }}" 
    :breadcrumbItems="['Dashboard', 'Categories']"
    />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-folder2 me-2"></i>
                {{ isset($category) ? 'Update Category' : 'Create Category' }}
            </h6>
            <a href="{{ route('admin.category.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="categoryForm" method="POST" enctype="multipart/form-data" 
            action="{{ isset($category) ? route('admin.category.update', $category->id) : route('admin.category.store') }}">
            @csrf
            @if(isset($category)) @method('PUT') @endif

            <div class="row g-3">

                <div class="col-lg-8">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-3 border-bottom pb-2">Category Details</h5>

                            <div class="row g-3">
                                <x-input-field 
                                type="text" 
                                name="name" 
                                label="Category Name" 
                                :value="old('name', $category->name ?? '')" 
                                cols="col-12" 
                                required 
                                placeholder="e.g., Electronics"/>



                                <x-input-field 
                                type="textarea" 
                                name="description" 
                                label="Full Description" 
                                :value="old('description', $category->description ?? '')" 
                                cols="col-12" 
                                rows="4" 
                                editor="true" 
                                placeholder="Detailed content for the category page..."
                                title="Rich text content for SEO and user engagement"
                                aria-describedby="descHelp"/>
                       

                                <div class="col-12 mt-3 pt-3 border-top">
                                    <h6 class="mb-3">SEO Settings</h6>
                                    <div class="row g-3">
                                        <x-input-field 
                                        type="text" 
                                        name="meta_keywords" 
                                        label="Meta Keywords" 
                                        :value="old('meta_keywords', $category->meta_keywords ?? '')" 
                                        cols="col-12" 
                                        placeholder="Comma separated keywords"/>

                                        <x-input-field 
                                        type="textarea" 
                                        name="meta_description" 
                                        label="Meta Description" 
                                        :value="old('meta_description', $category->meta_description ?? '')" 
                                        cols="col-12" 
                                        placeholder="SEO description (150-160 chars)"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-3 border-bottom pb-2">Settings & Media</h5>

                            <div class="row g-3">



                              <x-input-field 
                              type="textarea" 
                              name="excerpt" 
                              label="Short Excerpt" 
                              :value="old('excerpt', $category->excerpt ?? '')" 
                              cols="col-12" 
                              rows="3" 
                              placeholder="Brief summary shown in category listings..."
                              title="Appears in category grids and breadcrumbs"
                              aria-describedby="excerptHelp"/>
                              <small id="excerptHelp" class="form-text text-muted">Keep under 160 characters for best display</small>

                              <x-input-field 
                              type="text" 
                              name="font_icon" 
                              label="Font Icon Class" 
                              :value="old('font_icon', $category->font_icon ?? '')" 
                              cols="col-md-12" 
                              placeholder="e.g., bi bi-shop"/>

                              <div class="col-12">
                                <label class="form-label fw-semibold">Parent Category</label>
                                <select name="parent_id" class="form-select">
                                    <option value="">None (Root Category)</option>
                                    @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" 
                                        {{ old('parent_id', $category->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <x-input-field 
                            type="number" 
                            name="order_level" 
                            label="Display Order" 
                            :value="old('order_level', $category->order_level ?? '0')" 
                            cols="col-12" 
                            min="0" 
                            placeholder="0 = Highest priority"/>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Display On</label>
                                <select name="display_on" class="form-select">
                                    <option value="default" {{ old('display_on', $category->display_on ?? '') == 'default' ? 'selected' : '' }}> Default</option>
                                    <option value="header" {{ old('display_on', $category->display_on ?? '') == 'header' ? 'selected' : '' }}> Header</option>
                                    <option value="footer" {{ old('display_on', $category->display_on ?? '') == 'footer' ? 'selected' : '' }}> Footer</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Category Image</label>
                                <input type="file" name="image" class="form-control" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'imagePreview')">
                                <small class="text-muted d-block mt-1">Optional • Max 2MB • JPG/PNG/WebP</small>
                            </div>

                            <div class="col-12 text-center">
                                <img src="{{ isset($category) && $category->image_url ? $category->image_url : asset('default/noimage.png') }}" 
                                alt="Preview" 
                                class="img-fluid preview-image border" 
                                id="imagePreview" 
                                style="max-height: 150px; width: auto; object-fit: cover;">
                            </div>

                            <div class="col-12 mt-4 pt-2 border-top">
                                <button type="submit" class="btn btn-primary w-100 py-2">
                                    <i class="bi bi-save me-2"></i> 
                                    {{ isset($category) ? 'Update Category' : 'Create Category' }}
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
        $('#categoryForm').on('submit', function(e) {
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
                    setTimeout(() => { window.location.href = '{{ route("admin.category.index") }}'; }, 1500);
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html(originalBtnText);
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            $('[name="' + field + '"]').addClass('is-invalid')
                            .after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
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