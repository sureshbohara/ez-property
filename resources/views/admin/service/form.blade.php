@extends('layouts.app')
@section('title', isset($service) ? 'Edit Service' : 'Create Service')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Service" subTitle="{{ isset($service) ? 'Update Service' : 'Create Service' }}" :breadcrumbItems="['Dashboard', 'Service']" />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">{{ isset($service) ? 'Update Service' : 'Create Service' }}</h6>
            <a href="{{ route('admin.service.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="serviceForm" method="POST" enctype="multipart/form-data" 
                  action="{{ isset($service) ? route('admin.service.update', $service->id) : route('admin.service.store') }}">
                @csrf
                @if(isset($service)) @method('PUT') @endif
                
                <div class="row g-3">
             
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Service Information</h5>
                                <div class="row g-3">
                                    <x-input-field type="text" name="title" label="Service Title" :value="old('title', $service->title ?? '')" cols="col-6" required placeholder="Enter service title" />
                                    <x-input-field type="text" name="subtitle" label="Subtitle" :value="old('subtitle', $service->subtitle ?? '')" cols="col-6" placeholder="Enter subtitle" />
                                    <x-input-field type="textarea" name="short_content" label="Short Content" :value="old('short_content', $service->short_content ?? '')" cols="col-12" rows="3" placeholder="Brief description..." />
                                    <x-input-field type="textarea" name="long_content" label="Long Content" :value="old('long_content', $service->long_content ?? '')" cols="col-12" rows="6" placeholder="Detailed description..." editor="true"/>

                                          <div class="col-12 mt-3 pt-3 border-top">
                                        <h6 class="mb-3">SEO Settings</h6>
                                        <div class="row g-3">
                                            <x-input-field 
                                                type="text" 
                                                name="meta_keywords" 
                                                label="Meta Keywords" 
                                                :value="old('meta_keywords', $service->meta_keywords ?? '')" 
                                                cols="col-12" 
                                                placeholder="Comma separated keywords"/>

                                            <x-input-field 
                                                type="text" 
                                                name="meta_description" 
                                                label="Meta Description" 
                                                :value="old('meta_description', $service->meta_description ?? '')" 
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
                                <h5 class="card-title mb-3">Settings & Media</h5>
                                <div class="row g-3">




                                    <x-input-field type="text" name="icon" label="Font Icon" :value="old('icon', $service->icon ?? 'fas fa-plane')" cols="col-12"  placeholder="fas fa-plane" />


                                    <x-input-field type="number" name="order_level" label="Display Order" :value="old('order_level', $service->order_level ?? '0')" cols="col-12" min="0" placeholder="0 = highest priority" />
                                    
                                    <div class="col-12">
                                        <label class="form-label">Main Image</label>
                                        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this, 'imagePreview')">
                                        <small class="text-muted">Max: 2MB</small>
                                    </div>

                                    <div class="col-12 text-center">
                                        <img src="{{ isset($service) && $service->image ? $service->image_url : asset('default/noimage.png') }}" alt="Preview" class="img-fluid rounded preview-image" id="imagePreview" style="max-height: 150px; width: auto;">
                                    </div>

                                    <div class="col-12 mt-2">
                                        <label class="form-label">Feature Image</label>
                                        <input type="file" name="feature_image" class="form-control" accept="image/*" onchange="previewImage(this, 'featureImagePreview')">
                                        <small class="text-muted">Max: 3MB</small>
                                    </div>

                                    <div class="col-12 text-center">
                                        <img src="{{ isset($service) && $service->feature_image ? $service->feature_image_url : asset('default/noimage.png') }}" alt="Preview" class="img-fluid rounded preview-image" id="featureImagePreview" style="max-height: 150px; width: auto;">
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="bi bi-save"></i> {{ isset($service) ? 'Update Service' : 'Create Service' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

       
                <div class="card mt-4 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">🔄 Process Steps</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">

                                <x-input-field type="text" name="process_title" label="Process Title" :value="old('process_title', $service->process_title ?? '')" placeholder="e.g., How It Works" />
                            </div>
                            <div class="col-md-6">
                                <x-input-field type="text" name="process_sub_title" label="Process Sub Title" :value="old('process_sub_title', $service->process_sub_title ?? '')" placeholder="Brief description" />
                            </div>
                        </div>
                        
                        <div id="processItemsContainer">
                            @php $processItems = old('process_item', $service->process_item ?? []); @endphp
                            @if(is_array($processItems) && count($processItems) > 0)
                                @foreach($processItems as $index => $item)
                                    @include('admin.service._process_item', ['index' => $index, 'item' => $item])
                                @endforeach
                            @else
                                @include('admin.service._process_item', ['index' => 0, 'item' => null])
                            @endif
                        </div>
                        
                        <button type="button" class="btn btn-secondary btn-sm mt-2" id="addProcessItem">
                            <i class="bi bi-plus-circle"></i> Add Process Step
                        </button>
                    </div>
                </div>

                
                <div class="card mt-4 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">✨ Highlight Titles</h5>
                        <button type="button" class="btn btn-primary btn-sm addHighlightTitle">
                            <i class="bi bi-plus-circle"></i> Add Title
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="highlightTitlesContainer">
                            @php 
                                $highlightTitles = old('highlight.sections', $service->highlight['sections'] ?? []); 
                            @endphp
                            @if(is_array($highlightTitles) && count($highlightTitles) > 0)
                                @foreach($highlightTitles as $index => $title)
                                    @include('admin.service._highlight_title', ['index' => $index, 'title' => $title])
                                @endforeach
                            @else
                                @include('admin.service._highlight_title', ['index' => 0, 'title' => null])
                            @endif
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')

<script id="processItemTemplate" type="text/x-custom-template">
    <div class="card card-body mb-3 border processItem bg-light">
        <div class="d-flex justify-content-between mb-2">
            <span class="fw-bold">Step #<span class="stepNumber">1</span></span>
            <button type="button" class="btn btn-sm btn-danger removeProcessItem">Remove</button>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Title</label>
                <input type="text" name="process_item[__INDEX__][title]" class="form-control" placeholder="Step title">
            </div>
            <div class="col-md-6">
                <label class="form-label">Image</label>
                <input type="file" name="process_item[__INDEX__][image]" class="form-control" accept="image/*">
            </div>
            <div class="col-12">
                <label class="form-label">Content</label>
                <textarea name="process_item[__INDEX__][content]" class="form-control" rows="2" placeholder="Brief description"></textarea>
            </div>
        </div>
    </div>
</script>


<script id="highlightTitleTemplate" type="text/x-custom-template">
    <div class="input-group mb-2 highlightTitleItem">
        <input type="text" name="highlight[sections][]" class="form-control" placeholder="Enter highlight title..." value="">
        <button type="button" class="btn btn-outline-danger removeHighlightTitle" title="Remove">
            <i class="bi bi-trash"></i>
        </button>
    </div>
</script>

<script>
$(document).ready(function() {
    
    // AJAX Form Submission
    $('#serviceForm').on('submit', function(e) {
        e.preventDefault();
        $('.text-danger').remove();
        $('.is-invalid').removeClass('is-invalid');
        
        let formData = new FormData(this);
        let url = $(this).attr('action');
        let submitBtn = $(this).find('button[type="submit"]');
        
        submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Processing...');
        
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                toastr.success(response.message);
                setTimeout(() => { window.location.href = '{{ route("admin.service.index") }}'; }, 1500);
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html('<i class="bi bi-save"></i> {{ isset($service) ? "Update" : "Create" }} Service');
                if (xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function(field, errors) {
                        let input = $('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.after('<div class="text-danger small">' + errors[0] + '</div>');
                    });
                    toastr.error('Please fix the form errors');
                } else {
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                }
            }
        });
    });


    let processIndex = {{ count(old('process_item', $service->process_item ?? [])) }};
    
    $('#addProcessItem').on('click', function() {
        let template = $('#processItemTemplate').html();
        template = template.replace(/__INDEX__/g, processIndex);
        template = template.replace(/Step #<span class="stepNumber">1<\/span>/, `Step #<span class="stepNumber">${processIndex + 1}</span>`);
        $('#processItemsContainer').append(template);
        processIndex++;
        updateProcessStepNumbers();
    });
    
    $('#processItemsContainer').on('click', '.removeProcessItem', function() {
        $(this).closest('.processItem').remove();
        updateProcessStepNumbers();
    });
    
    function updateProcessStepNumbers() {
        $('#processItemsContainer .processItem').each(function(index) {
            $(this).find('.stepNumber').text(index + 1);
        });
    }


    let highlightIndex = {{ count(old('highlight.sections', $service->highlight['sections'] ?? [])) }};
    
    $('.addHighlightTitle').on('click', function() {
        let template = $('#highlightTitleTemplate').html();
        template = template.replace(/__INDEX__/g, highlightIndex);
        $('.highlightTitlesContainer').append(template);
        highlightIndex++;
    });
    
    $('.highlightTitlesContainer').on('click', '.removeHighlightTitle', function() {
        $(this).closest('.highlightTitleItem').remove();
    });
});
</script>
@endpush