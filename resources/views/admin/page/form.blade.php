@extends('layouts.app')

@section('title', isset($page) ? 'Edit Page' : 'Create Page')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Pages" subTitle="{{ isset($page) ? 'Update Page' : 'Create Page' }}" :breadcrumbItems="['Dashboard', 'Pages']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>{{ isset($page) ? 'Update Page' : 'Create Page' }}</h6>
            <a href="{{ route('admin.page.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to List</a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="pageForm" method="POST" enctype="multipart/form-data" action="{{ isset($page) ? route('admin.page.update', $page->id) : route('admin.page.store') }}">
                @csrf
                @if(isset($page)) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Page Content</h5>
                                <div class="row g-3">

                                    <x-input-field type="text" name="title" label="Page Title" :value="old('title', $page->title ?? '')" cols="col-12" required placeholder="e.g., About Us" title="Enter the page title"/>
                                    
                              

                                    <x-input-field type="textarea" name="short_content" label="Short Content / Excerpt" :value="old('short_content', $page->short_content ?? '')" cols="col-12" rows="2" placeholder="Brief summary shown in previews..." title="Short description"/>


                                    <x-input-field type="textarea" name="content" label="Full Page Content" :value="old('content', $page->content ?? '')" cols="col-12" rows="12" editor="true" placeholder="Write your full page content here..." title="Main content (supports HTML)"/>




                                  
                                    <div class="col-12"><hr class="my-2"><h6 class="text-muted mb-2"> SEO Settings</h6></div>

                                    <x-input-field type="text" name="meta_title" label="Meta Title" :value="old('meta_title', $page->meta_title ?? '')" cols="col-12" placeholder="SEO title"/>


                                    <x-input-field type="textarea" name="meta_description" label="Meta Description" :value="old('meta_description', $page->meta_description ?? '')" cols="col-12" rows="2" placeholder="Brief description for search engines..."/>

                                    <x-input-field type="text" name="meta_keywords" label="Meta Keywords" :value="old('meta_keywords', $page->meta_keywords ?? '')" cols="col-12" placeholder="keyword1, keyword2"/>
                                        
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">

                                <h5 class="card-title mb-3 border-bottom pb-2">Settings</h5>
                                <div class="row g-3">

                                    <x-input-field type="text" name="icon" label="Icon (Bootstrap)" :value="old('icon', $page->icon ?? '')" cols="col-12" placeholder="bi-info-circle" title="e.g., bi-info-circle"/>

                                    <x-input-field type="number" name="order_level" label="Display Order" :value="old('order_level', $page->order_level ?? '0')" cols="col-12" min="0" placeholder="0 = Highest priority"/>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold" for="image"> Page Banner/Image</label>
                                        <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'imagePreview')">
                                        <small class="text-muted d-block mt-1">Recommended: 1200x400px</small>
                                    </div>


                                    <div class="col-12 text-center">
                                        <img src="{{ isset($page) && $page->image_url ? $page->image_url : asset('default/noimage.png') }}" alt="Page Preview" class="img-fluid preview-image border" id="imagePreview">

                                        <small class="text-muted d-block mt-1" id="imageHint">{{ isset($page) && $page->image ? '✓ Current image loaded' : 'No image selected' }}</small>
                                    </div>

                                    <div class="col-12"><hr class="my-2"><h6 class="text-muted mb-2"> Visibility </h6></div>

                                    <div class="col-12">
                                        <input type="hidden" name="show_in_menu" value="0">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="show_in_menu" id="show_in_menu" value="1" {{ old('show_in_menu', $page->show_in_menu ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show_in_menu">Show in Main Menu</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <input type="hidden" name="show_in_footer" value="0">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="show_in_footer" id="show_in_footer" value="1" {{ old('show_in_footer', $page->show_in_footer ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show_in_footer">Show in Footer</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <input type="hidden" name="is_featured" value="0">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $page->is_featured ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">Featured Page</label>
                                        </div>
                                    </div>


                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2"><i class="bi bi-save me-2"></i> {{ isset($page) ? 'Update Page' : 'Create Page' }}</button>
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
        $('#pageForm').on('submit', function(e) {
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
                    setTimeout(() => { window.location.href = '{{ route("admin.page.index") }}'; }, 1500);
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