@extends('layouts.app')
@section('title', isset($fleet) ? 'Edit Fleet' : 'Create Fleet')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Fleet" subTitle="{{ isset($fleet) ? 'Update Fleet' : 'Create Fleet' }}" :breadcrumbItems="['Dashboard', 'Fleet']" />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">{{ isset($fleet) ? 'Update Fleet' : 'Create Fleet' }}</h6>
            <a href="{{ route('admin.fleet.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="fleetForm" method="POST" enctype="multipart/form-data" 
            action="{{ isset($fleet) ? route('admin.fleet.update', $fleet->id) : route('admin.fleet.store') }}">
            @csrf
            @if(isset($fleet)) @method('PUT') @endif

            <div class="row g-3">

                <div class="col-lg-8">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Fleet Information</h5>
                            <div class="row g-3">

                                <x-input-field type="text" name="title" label="Fleet Title" :value="old('title', $fleet->title ?? '')" cols="col-6" required placeholder="Enter fleet title" />

                                    <x-input-field type="text" name="subtitle" label="Subtitle" :value="old('subtitle', $fleet->subtitle ?? '')" cols="col-6" placeholder="Enter subtitle" />

                                        <x-input-field type="text" name="bags" label="Bags Capacity" :value="old('bags', $fleet->bags ?? '')" cols="col-6" placeholder="e.g., 2 Large, 2 Small" />

                                            <x-input-field type="text" name="passengers" label="Passengers Capacity" :value="old('passengers', $fleet->passengers ?? '')" cols="col-6" placeholder="e.g., 4 Passengers" />

                                                <x-input-field type="textarea" name="short_content" label="Short Content" :value="old('short_content', $fleet->short_content ?? '')" cols="col-12" rows="4" placeholder="Brief description..." />




                                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                            <h5 class="mb-0">✨ Highlight Point</h5>
                                                            <button type="button" class="btn btn-primary btn-sm addHighlightTitle">
                                                                <i class="bi bi-plus-circle"></i> Add Title
                                                            </button>
                                                        </div>

                                                            <div class="highlightTitlesContainer">
                                                                @php 
                                                                $highlightTitles = old('highlight.sections', $fleet->highlight['sections'] ?? []); 
                                                                @endphp
                                                                @if(is_array($highlightTitles) && count($highlightTitles) > 0)
                                                                @foreach($highlightTitles as $index => $title)
                                                                @include('admin.fleet._highlight_title', ['index' => $index, 'title' => $title])
                                                                @endforeach
                                                                @else
                                                                @include('admin.fleet._highlight_title', ['index' => 0, 'title' => null])
                                                                @endif
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

                                                    <x-input-field type="number" name="order_level" label="Display Order" :value="old('order_level', $fleet->order_level ?? '0')" cols="col-12" min="0" placeholder="0 = highest priority" />

                                                        <div class="col-12">
                                                            <label class="form-label">Main Image</label>
                                                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this, 'imagePreview')">
                                                            <small class="text-muted">Max: 2MB</small>
                                                        </div>

                                                        <div class="col-12 text-center">
                                                            <img src="{{ isset($fleet) && $fleet->image ? $fleet->image_url : asset('default/noimage.png') }}" alt="Preview" class="img-fluid rounded preview-image" id="imagePreview" style="max-height: 150px; width: auto;">
                                                        </div>

                                                        <div class="col-12 mt-2">
                                                            <label class="form-label">Feature Image</label>
                                                            <input type="file" name="feature_image" class="form-control" accept="image/*" onchange="previewImage(this, 'featureImagePreview')">
                                                            <small class="text-muted">Max: 3MB</small>
                                                        </div>

                                                        <div class="col-12 text-center">
                                                            <img src="{{ isset($fleet) && $fleet->feature_image ? $fleet->feature_image_url : asset('default/noimage.png') }}" alt="Preview" class="img-fluid rounded preview-image" id="featureImagePreview" style="max-height: 150px; width: auto;">
                                                        </div>

                                                        <div class="col-12 mt-4">
                                                            <button type="submit" class="btn btn-primary w-100">
                                                                <i class="bi bi-save"></i> {{ isset($fleet) ? 'Update Fleet' : 'Create Fleet' }}
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
                            $('#fleetForm').on('submit', function(e) {
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
                                        setTimeout(() => { window.location.href = '{{ route("admin.fleet.index") }}'; }, 1500);
                                    },
                                    error: function(xhr) {
                                        submitBtn.prop('disabled', false).html('<i class="bi bi-save"></i> {{ isset($fleet) ? "Update" : "Create" }} Fleet');
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
                            let highlightIndex = {{ count(old('highlight.sections', $fleet->highlight['sections'] ?? [])) }};
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