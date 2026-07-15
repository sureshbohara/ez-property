@extends('layouts.app')
@section('title', isset($listing) ? 'Edit Listing' : 'Create Listing')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Listings" subTitle="{{ isset($listing) ? 'Update' : 'Create' }}" :breadcrumbItems="['Dashboard', 'Listings']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-house-door me-2"></i> {{ isset($listing) ? 'Update' : 'Create' }} Listing</h6>
            <a href="{{ route('listing.listing.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="listingForm" method="POST" enctype="multipart/form-data" action="{{ isset($listing) ? route('listing.listing.update', $listing->id) : route('listing.listing.store') }}">
                @csrf
                @if(isset($listing)) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Basic Information</h5>
                                <x-input-field type="text" name="title" label="Listing Title" :value="old('title', $listing?->title ?? '')" cols="col-12" required placeholder="e.g., Cozy Apartment in Thamel"/>
                                <x-input-field type="textarea" name="description" label="Full Description" :value="old('description', $listing?->description ?? '')" cols="col-12" rows="6" editor="true"/>

                                <h5 class="card-title mb-3 mt-4 border-bottom pb-2">Location</h5>
                                <div class="row g-3">
                                    <x-input-field type="text" name="address" label="Street Address" :value="old('address', $listing?->address ?? '')" cols="col-12" required/>
                                    <x-input-field type="text" name="city" label="City" :value="old('city', $listing?->city ?? '')" cols="col-md-4" required/>
                                    <x-input-field type="text" name="province" label="Province/State" :value="old('province', $listing?->province ?? '')" cols="col-md-4" required/>
                                    <x-input-field type="text" name="country" label="Country" :value="old('country', $listing?->country ?? 'Nepal')" cols="col-md-4" required/>
                                    <x-input-field type="number" name="latitude" label="Latitude" :value="old('latitude', $listing?->latitude ?? '')" cols="col-md-6" step="any" placeholder="e.g., 27.7172"/>
                                    <x-input-field type="number" name="longitude" label="Longitude" :value="old('longitude', $listing?->longitude ?? '')" cols="col-md-6" step="any" placeholder="e.g., 85.3240"/>
                                </div>

                                <h5 class="card-title mb-3 mt-4 border-bottom pb-2">Amenities</h5>
                                <div class="row g-2">
                                    @foreach($amenities as $amenity)
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity->id }}" id="amenity_{{ $amenity->id }}"
                                                    {{ in_array($amenity->id, old('amenities', $listing?->amenities?->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="amenity_{{ $amenity->id }}">
                                                    @if($amenity->icon) <i class="{{ $amenity->icon }} me-1"></i> @endif
                                                    {{ $amenity->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="col-12 mt-4 pt-3 border-top">
                                    <h6 class="mb-3 text-primary"><i class="bi bi-star-fill me-1"></i> Highlights</h6>
                                    <div class="featureDisplay">
                                        @if(isset($listing) && !empty($listing->highlight_key))
                                            @foreach($listing->highlight_key as $highlight)
                                                <div class="row featureItem mb-2 align-items-center">
                                                    <div class="col-10">
                                                        <input type="text" name="highlight_key[]" class="form-control" value="{{ $highlight }}" placeholder="Highlight point">
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-danger btn-sm removeFeature w-100"><i class="bi bi-trash"></i></button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm addFeatures mt-2">
                                        <i class="bi bi-plus-circle"></i> Add Highlight
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 mt-4 border-bottom pb-2">Capacity</h5>
                                <div class="row g-3">
                                    <x-input-field type="number" name="guests" label="Max Guests" :value="old('guests', $listing?->guests ?? '1')" cols="col-md-12" min="1"/>
                                    <x-input-field type="number" name="bedrooms" label="Bedrooms" :value="old('bedrooms', $listing?->bedrooms ?? '1')" cols="col-md-12" min="0"/>
                                    <x-input-field type="number" name="beds" label="Beds" :value="old('beds', $listing?->beds ?? '1')" cols="col-md-12" min="0"/>
                                    <x-input-field type="number" name="bathrooms" label="Bathrooms" :value="old('bathrooms', $listing?->bathrooms ?? '1')" cols="col-md-12" min="0" step="0.5"/>
                                </div>

                                <h5 class="card-title mb-3 border-bottom pb-2">Pricing & Rules</h5>
                                <x-input-field type="number" name="base_price" label="Base Price (per night)" :value="old('base_price', $listing?->base_price ?? '')" cols="col-12" step="0.01" required/>
                                <x-input-field type="number" name="cleaning_fee" label="Cleaning Fee" :value="old('cleaning_fee', $listing?->cleaning_fee ?? '')" cols="col-12" step="0.01"/>
                                <x-input-field type="number" name="minimum_nights" label="Minimum Nights" :value="old('minimum_nights', $listing?->minimum_nights ?? '1')" cols="col-12" min="1"/>
                                
                                <div class="form-check form-switch mt-3">
                                    <input class="form-check-input" type="checkbox" name="instant_bookable" value="1" id="instantBookable" {{ old('instant_bookable', $listing?->instant_bookable ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="instantBookable"><strong>Instant Bookable</strong></label>
                                </div>

                                <h5 class="card-title mb-3 mt-4 border-bottom pb-2">Media</h5>
                                <label class="form-label fw-semibold">Cover Image</label>
                                <input type="file" name="image" class="form-control mb-2" accept="image/*" onchange="previewImage(this, 'coverPreview')">
                                <div class="text-center mb-3">
                                    <img src="{{ isset($listing) && $listing->image_url ? $listing->image_url : asset('default/noimage.png') }}" class="img-fluid border" id="coverPreview" style="max-height: 150px; object-fit: cover; width: 100%;">
                                </div>
                                
                                <label class="form-label fw-semibold">Gallery</label>
                                <input type="file" name="gallery[]" class="form-control" multiple accept="image/*">

                                @if(isset($listing) && !empty($listing->gallery))
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        @foreach($listing->gallery as $img)
                                            <div class="gallery-image" style="position:relative;">
                                                <img src="{{ asset('images/'.$img) }}" width="60" height="60" style="object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                                                <button type="button" class="btn btn-danger btn-sm delete-gallery-image" data-image="{{ $img }}" style="position:absolute; top:-5px; right:-5px; padding: 0 4px; font-size: 10px;"><i class="bi bi-trash"></i></button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <h5 class="card-title mb-3 mt-4 border-bottom pb-2">Settings</h5>
                                
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-semibold">Category</label>
                                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $listing?->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                              
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-semibold">Property Type</label>
                                    <select name="listing_type" class="form-select @error('listing_type') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('listing_type', $listing?->listing_type ?? '') == '' ? 'selected' : '' }}>-- Select Property Type --</option>
                                        @foreach($propertyTypes as $value => $label)
                                            <option value="{{ $value }}" {{ old('listing_type', $listing?->listing_type ?? '') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('listing_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                           
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-semibold">Cancellation Policy</label>
                                    <select name="cancellation_policy" class="form-select @error('cancellation_policy') is-invalid @enderror" required>
                                        <option value="" disabled>-- Select Policy --</option>
                                        @foreach($cancellationPolicies as $value => $label)
                                            <option value="{{ $value }}" {{ old('cancellation_policy', $listing?->cancellation_policy ?? '') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cancellation_policy') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <x-input-field type="number" name="order_level" label="Display Order" :value="old('order_level', $listing?->order_level ?? '0')" cols="col-12" min="0"/>
                                
                                <div class="form-check form-switch mt-3">
                                    <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ old('status', $listing?->status ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status"><strong>Active</strong></label>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-2 mt-4">
                                    <i class="bi bi-save me-2"></i> {{ isset($listing) ? 'Update' : 'Create' }} Listing
                                </button>
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
        // 1. Add/Remove Highlights
        $('.addFeatures').click(function() {
            $('.featureDisplay').append(`
                <div class="row featureItem mb-2 align-items-center">
                    <div class="col-10">
                        <input type="text" name="highlight_key[]" class="form-control" placeholder="Highlight point">
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger btn-sm removeFeature w-100"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
            `);
        });
        $(document).on('click', '.removeFeature', function() { 
            $(this).closest('.featureItem').remove(); 
        });

        // 2. Gallery Delete
        $(document).on('click', '.delete-gallery-image', function() {
            if (!confirm('Delete this image?')) return;
            var btn = this;
            var listingId = {{ isset($listing) ? $listing->id : 0 }}; 
            $.ajax({
                type: 'POST', 
                url: "{{ route('listing.listing.delete.gallery') }}",
                data: { 
                    image: $(this).data('image'), 
                    id: listingId, 
                    _token: "{{ csrf_token() }}" 
                },
                success: (res) => { 
                    if(res.status === 200){ 
                        toastr.success(res.msg); 
                        $(btn).closest('.gallery-image').remove(); 
                    } else {
                        toastr.error(res.msg || 'Failed to delete image'); 
                    }
                },
                error: () => {
                    toastr.error('Something went wrong while deleting the image.');
                }
            });
        });

        // Form Submission
        $('#listingForm').on('submit', function(e) {
            e.preventDefault();
            $('.text-danger').remove(); 
            $('.is-invalid').removeClass('is-invalid');
            const formData = new FormData(this);
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Processing...');
            
            $.ajax({
                type: 'POST', 
                url: $(this).attr('action'), 
                data: formData, 
                contentType: false, 
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: (res) => { 
                    toastr.success(res.message); 
                    setTimeout(() => window.location.href = '{{ route("listing.listing.index") }}', 1000); 
                },
                error: (xhr) => {
                    submitBtn.prop('disabled', false).html(originalText);
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, (field, errors) => {
                            let escapedField = field.replace(/\[/g, '\\[').replace(/\]/g, '\\]');
                            let $field = $(`[name="${escapedField}"]`).first();
                            if ($field.length === 0 && field.includes('[]')) {
                                $field = $(`[name^="${field.replace('[]', '')}"]`).last();
                            }
                            $field.addClass('is-invalid').after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
                        });
                        toastr.error('Please fix the errors');
                    } else {
                        toastr.error('Something went wrong');
                    }
                }
            });
        });
    });
</script>
@endpush