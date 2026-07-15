@extends('layouts.app')
@section('title', isset($package) ? 'Edit Package' : 'Create Package')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Packages" subTitle="{{ isset($package) ? 'Update Package' : 'Create Package' }}" :breadcrumbItems="['Dashboard', 'Packages']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-bag me-2"></i> {{ isset($package) ? 'Update Package' : 'Create Package' }}</h6>
            <a href="{{ route('admin.package.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="packageForm" method="POST" enctype="multipart/form-data" action="{{ isset($package) ? route('admin.package.update', $package->id) : route('admin.package.store') }}">
                @csrf
                @if(isset($package)) @method('PUT') @endif

                <div class="row g-3">
                    <!-- Left Column -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Package Details</h5>
                                <div class="row g-3">
                                    <x-input-field type="text" name="name" label="Package Name" :value="old('name', $package->name ?? '')" cols="col-md-12" required placeholder="e.g., Everest Base Camp Trek"/>
                                    
                                    <x-input-field type="textarea" name="description" label="Short Description" :value="old('description', $package->description ?? '')" cols="col-12" rows="3" editor="true"/>
                                    <x-input-field type="textarea" name="content" label="Full Content" :value="old('content', $package->content ?? '')" cols="col-12" rows="6" editor="true"/>

                                    <!-- Trip Facts -->
                                    <div class="col-12 mt-4 pt-3 border-top">
                                        <h6 class="mb-3 text-primary">Trip Facts</h6>
                                        <div class="row g-3">
                                            <x-input-field type="text" name="duration" label="Duration" :value="old('duration', $package->duration ?? '')" cols="col-md-4" placeholder="14 Days"/>
                                            <x-input-field type="text" name="max_altitude" label="Max Altitude" :value="old('max_altitude', $package->max_altitude ?? '')" cols="col-md-4" placeholder="5,545m"/>
                                            <x-input-field type="text" name="best_season" label="Best Season" :value="old('best_season', $package->best_season ?? '')" cols="col-md-4" placeholder="Mar - May"/>
                                            <x-input-field type="text" name="meals" label="Meals" :value="old('meals', $package->meals ?? '')" cols="col-md-4" placeholder="B/L/D"/>
                                            <x-input-field type="text" name="accommodation" label="Accommodation" :value="old('accommodation', $package->accommodation ?? '')" cols="col-md-4" placeholder="Tea House"/>
                                            <x-input-field type="text" name="transportation" label="Transportation" :value="old('transportation', $package->transportation ?? '')" cols="col-md-4" placeholder="Flight"/>
                                            <x-input-field type="text" name="trip_grading" label="Trip Grading" :value="old('trip_grading', $package->trip_grading ?? '')" cols="col-md-12" placeholder="Moderate"/>
                                        </div>
                                    </div>

                                
                                    <div class="col-12 mt-4 pt-3 border-top">
                                        <h6 class="mb-3 text-primary">Trip Highlights</h6>
                                        <div class="featureDisplay">
                                            @if(isset($package) && !empty($package->highlight_key))
                                                @foreach($package->highlight_key as $highlight)
                                                    <div class="row featureItem mb-2">
                                                        <div class="col-10"><input type="text" name="highlight_key[]" class="form-control" value="{{ $highlight }}" placeholder="Highlight point"></div>
                                                        <div class="col-2"><button type="button" class="btn btn-danger btn-sm removeFeature"><i class="bi bi-trash"></i></button></div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-custom btn-sm addFeatures"><i class="bi bi-plus-circle"></i> Add Highlight</button>
                                    </div>

                                  
                            
                                <div class="col-12 mt-4 pt-3 border-top">
                                    <h6 class="mb-3 text-primary">
                                        <i class="bi bi-compass me-2"></i>Travel Styles / Activities
                                    </h6>
                                    <p class="text-muted small mb-3">Select  activities that apply to this package.</p>
    
 
    
                                    <div class="row g-3">
                                        @foreach(config('travel.activities') as $activity)
                                            <div class="col-lg-3 col-md-4 col-sm-6">
                                                <label class="activity-card">
                                                    <input type="checkbox" 
                                                           name="activities[]" 
                                                           value="{{ $activity }}" 
                                                           {{ in_array($activity, old('activities', $package->activities ?? [])) ? 'checked' : '' }}>
                                                    
                                                    <div class="activity-content">
                                                        {{ $activity }}
                                                    </div>
                                                    
                                                    <div class="check-mark">
                                                        <i class="bi bi-check"></i>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                               
                                    <div class="col-12 mt-4 pt-3 border-top">
                                        <h6 class="mb-3 text-primary">Frequently Asked Questions</h6>
                                        <div class="faqsDisplay">
                                            @if(isset($package) && is_array($package->faqs))
                                                @foreach($package->faqs as $index => $faq)
                                                    <div class="card mb-2 faqsConfiguration">
                                                        <div class="card-body p-2">
                                                            <div class="row">
                                                                <div class="col-11">
                                                                    <input type="text" name="faqs[{{ $index }}][label]" class="form-control mb-2" placeholder="Question" value="{{ $faq['label'] ?? '' }}">
                                                                    <textarea name="faqs[{{ $index }}][detail]" class="form-control" rows="2" placeholder="Answer">{{ $faq['detail'] ?? '' }}</textarea>
                                                                </div>
                                                                <div class="col-1 d-flex align-items-start">
                                                                    <button type="button" class="btn btn-danger btn-sm removeFaqs"><i class="bi bi-trash"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-custom btn-sm addFaqs"><i class="bi bi-plus-circle"></i> Add FAQ</button>
                                    </div>

                           
                                    <div class="col-12 mt-4 pt-3 border-top">
                                        <h6 class="mb-3 text-primary">SEO Settings</h6>
                                        <div class="row g-3">
                                            <x-input-field type="text" name="meta_title" label="Meta Title" :value="old('meta_title', $package->meta_title ?? '')" cols="col-12"/>
                                            <x-input-field type="text" name="meta_keywords" label="Meta Keywords" :value="old('meta_keywords', $package->meta_keywords ?? '')" cols="col-12"/>
                                            <x-input-field type="textarea" name="meta_description" label="Meta Description" :value="old('meta_description', $package->meta_description ?? '')" cols="col-12" rows="2"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-4">
                     
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">


                                <x-input-field type="textarea" name="excerpt" label="Short Excerpt" :value="old('excerpt', $package->excerpt ?? '')" cols="col-12"  placeholder="Brief summary..."/>

                                <h5 class="card-title mb-3 border-bottom pb-2">Categories</h5>
                                <div class="scrollable-container mb-3 p-2" style="max-height: 200px; overflow-y: auto;">
                                    @foreach($getCategories as $category)
                                        <div class="form-check mb-1">
                                            <input type="checkbox" class="form-check-input" name="category_id[]" id="cat-{{$category->id}}" value="{{$category->id}}" {{ in_array($category->id, old('category_id', $selectedCategoryIds ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="cat-{{$category->id}}">{{ $category->name }}</label>
                                        </div>
                                        @foreach($category->children as $subCat)
                                            <div class="form-check ms-3 mb-1">
                                                <input type="checkbox" class="form-check-input" name="category_id[]" id="subcat-{{$subCat->id}}" value="{{$subCat->id}}" {{ in_array($subCat->id, old('category_id', $selectedCategoryIds ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="subcat-{{$subCat->id}}">– {{ $subCat->name }}</label>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Pricing</h5>
                                <div class="row g-3">
                                    <x-input-field type="number" name="trip_previous_price" label="Previous Price" :value="old('trip_previous_price', $package->trip_previous_price ?? '')" cols="col-12" step="0.01"/>
                                    <x-input-field type="number" name="trip_price" label="Current Price" :value="old('trip_price', $package->trip_price ?? '')" cols="col-12" step="0.01"/>
                                </div>
                                <div class="col-12 mt-3 pt-3 border-top">
                                    <h6 class="mb-3">Group Size Pricing</h6>
                                    <div class="groupPrice">
                                        @if(isset($package) && is_array($package->group_size_price))
                                            @foreach($package->group_size_price as $index => $price)
                                                <div class="row mb-2 groupKeyRow">
                                                    <div class="col-5"><input type="text" name="group_size_price[{{ $index }}][label]" class="form-control form-control-sm" placeholder="1-5 pax" value="{{ $price['label'] ?? '' }}"></div>
                                                    <div class="col-5"><input type="number" step="0.01" name="group_size_price[{{ $index }}][price]" class="form-control form-control-sm" placeholder="999.99" value="{{ $price['price'] ?? '' }}"></div>
                                                    <div class="col-2"><button type="button" class="btn btn-danger btn-sm removePriceKey"><i class="bi bi-trash"></i></button></div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary addPriceBtn"><i class="bi bi-plus-circle"></i> Add Group Price</button>
                                </div>
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Settings</h5>
                                <div class="row g-3">
                                    <x-input-field type="number" name="order_level" label="Display Order" :value="old('order_level', $package->order_level ?? '0')" cols="col-12" min="0"/>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Display On</label>
                                        <select name="display_on" class="form-select">
                                            <option value="">Select Location</option>
                                            <option value="default" {{ old('display_on', $package->display_on ?? '') == 'default' ? 'selected' : '' }}> Default</option>
                                            <option value="header" {{ old('display_on', $package->display_on ?? '') == 'header' ? 'selected' : '' }}> Header</option>
                                            <option value="footer" {{ old('display_on', $package->display_on ?? '') == 'footer' ? 'selected' : '' }}> Footer</option>
                                            <option value="sidebar" {{ old('display_on', $package->display_on ?? '') == 'sidebar' ? 'selected' : '' }}> Sidebar</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Media -->
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Media</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">List Image</label>
                                        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this, 'imagePreview')">
                                        <div class="text-center mt-2"><img src="{{ isset($package) && $package->image_url ? $package->image_url : asset('default/noimage.png') }}" class="img-fluid border" id="imagePreview" style="max-height: 100px; object-fit: cover;"></div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Feature Image</label>
                                        <input type="file" name="feature_image" class="form-control" accept="image/*" onchange="previewImage(this, 'featureImagePreview')">
                                        <div class="text-center mt-2"><img src="{{ isset($package) && $package->feature_image_url ? $package->feature_image_url : asset('default/noimage.png') }}" class="img-fluid border" id="featureImagePreview" style="max-height: 100px; object-fit: cover;"></div>
                                    </div>
                                    <div class="col-12 mt-3 pt-3 border-top">
                                        <label class="form-label fw-semibold">Gallery</label>
                                        <input type="file" class="form-control" name="gallery[]" multiple accept="image/*">
                                    </div>
                                    @if(isset($package) && !empty($package->gallery))
                                        <div class="col-12">
                                            <label class="fw-semibold small">Current Gallery:</label>
                                            <div class="d-flex flex-wrap gap-2 mt-1">
                                                @foreach($package->gallery as $img)
                                                    <div class="gallery-image" style="position:relative; display:inline-block;">
                                                        <img src="{{ asset('images/'.$img) }}" width="60" height="60" style="object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                                                        <button type="button" class="btn btn-danger btn-sm delete-gallery-image" data-image="{{ $img }}" style="position:absolute; top:-5px; right:-5px; padding: 0 4px; font-size: 10px; line-height: 1.2;"><i class="bi bi-trash"></i></button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                               
                               <div class="row mt-5">
                                 <button type="submit" class="btn btn-primary w-100 py-2"><i class="bi bi-save me-2"></i> {{ isset($package) ? 'Update' : 'Create' }} Package</button>

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
        // Gallery Delete
        $(document).on('click', '.delete-gallery-image', function () {
            if (!confirm('Delete this image?')) return;
            var btn = this;
            $.ajax({
                type: 'POST', url: "{{ route('admin.package.delete.gallery.image') }}",
                data: { image: $(this).data('image'), id: {{ isset($package) ? $package->id : 0 }}, _token: "{{ csrf_token() }}" },
                success: (res) => { if(res.status===200){ toastr.success(res.msg); $(btn).closest('.gallery-image').remove(); } else toastr.error(res.msg); }
            });
        });

        // Highlights
        $('.addFeatures').click(() => $('.featureDisplay').append(`<div class="row featureItem mb-2"><div class="col-10"><input type="text" name="highlight_key[]" class="form-control" placeholder="Highlight"></div><div class="col-2"><button type="button" class="btn btn-danger btn-sm removeFeature"><i class="bi bi-trash"></i></button></div></div>`));
        $(document).on('click', '.removeFeature', function() { $(this).closest('.featureItem').remove(); });

        // FAQs
        $('.addFaqs').click(() => {
            let idx = Date.now();
            $('.faqsDisplay').append(`<div class="card mb-2 faqsConfiguration"><div class="card-body p-2"><div class="row"><div class="col-11"><input type="text" name="faqs[${idx}][label]" class="form-control mb-2" placeholder="Question"><textarea name="faqs[${idx}][detail]" class="form-control" rows="2" placeholder="Answer"></textarea></div><div class="col-1 d-flex align-items-start"><button type="button" class="btn btn-danger btn-sm removeFaqs"><i class="bi bi-trash"></i></button></div></div></div></div>`);
        });
        $(document).on('click', '.removeFaqs', function() { $(this).closest('.faqsConfiguration').remove(); });

        // Group Pricing
        $('.addPriceBtn').click(() => {
            let idx = Date.now();
            $('.groupPrice').append(`<div class="row mb-2 groupKeyRow"><div class="col-5"><input type="text" name="group_size_price[${idx}][label]" class="form-control form-control-sm" placeholder="1-5 pax"></div><div class="col-5"><input type="number" step="0.01" name="group_size_price[${idx}][price]" class="form-control form-control-sm" placeholder="999.99"></div><div class="col-2"><button type="button" class="btn btn-danger btn-sm removePriceKey"><i class="bi bi-trash"></i></button></div></div>`);
        });
        $(document).on('click', '.removePriceKey', function() { $(this).closest('.groupKeyRow').remove(); });

        // Form Submit
        $('#packageForm').on('submit', function(e) {
            e.preventDefault();
            $('.text-danger').remove(); $('.is-invalid').removeClass('is-invalid');
            const formData = new FormData(this);
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Processing...');

            $.ajax({
                type: 'POST', url: $(this).attr('action'), data: formData, contentType: false, processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: (res) => { toastr.success(res.message); setTimeout(() => window.location.href = '{{ route("admin.package.index") }}', 1000); },
                error: (xhr) => {
                    submitBtn.prop('disabled', false).html(originalText);
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, (field, errors) => {
                            $('[name="' + field + '"], [name="' + field + '[]"]').first().addClass('is-invalid').after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
                        });
                        toastr.error('Please fix the errors');
                    } else toastr.error('Something went wrong');
                }
            });
        });
    });
</script>
@endpush