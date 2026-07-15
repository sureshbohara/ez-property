@extends('layouts.app')
@section('title', isset($amenity) ? 'Edit Amenity' : 'Create Amenity')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Amenities" subTitle="{{ isset($amenity) ? 'Update' : 'Create' }}" :breadcrumbItems="['Dashboard', 'Amenities']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-check-circle me-2"></i> {{ isset($amenity) ? 'Update' : 'Create' }} Amenity</h6>
            <a href="{{ route('listing.amenity.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="amenityForm" method="POST" action="{{ isset($amenity) ? route('listing.amenity.update', $amenity->id) : route('listing.amenity.store') }}">
                @csrf
                @if(isset($amenity)) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Basic Information</h5>
                                
                                <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                                    <i class="bi bi-lightbulb me-2"></i>
                                    <strong>Tip:</strong> Use Bootstrap Icons (e.g., <code>bi-wifi</code>, <code>bi-car-front</code>) or FontAwesome (e.g., <code>fa-solid fa-swimming-pool</code>) for the icon field.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <x-input-field type="text" name="name" label="Amenity Name" :value="old('name', $amenity->name ?? '')" cols="col-md-12" required placeholder="e.g., Free Wi-Fi"/>
                              
                                
                              
                                
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Description</label>
                                    <textarea name="description" class="form-control" rows="8" placeholder="Short description of this amenity">{{ old('description', $amenity->description ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Settings</h5>

                                <x-input-field type="text" name="slug" label="Slug" :value="old('slug', $amenity->slug ?? '')" cols="col-md-12" placeholder="auto-generated if empty"/>
                                <x-input-field type="text" name="icon" label="Icon Class" :value="old('icon', $amenity->icon ?? '')" cols="col-md-12" placeholder="e.g., bi-wifi"/>
                                <x-input-field type="number" name="order_level" label="Display Order" :value="old('order_level', $amenity->order_level ?? '0')" cols="col-md-12" min="0"/>
                                
                                <div class="col-12 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ old('status', $amenity->status ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status">
                                            <strong>Active</strong>
                                            <small class="d-block text-muted">Visible to users when creating listings</small>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-2 mt-3">
                                    <i class="bi bi-save me-2"></i> {{ isset($amenity) ? 'Update' : 'Create' }} Amenity
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
        $('#amenityForm').on('submit', function(e) {
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
                    setTimeout(() => window.location.href = '{{ route("listing.amenity.index") }}', 1000); 
                },
                error: (xhr) => {
                    submitBtn.prop('disabled', false).html(originalText);
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, (field, errors) => {
                            $('[name="' + field + '"]').first().addClass('is-invalid').after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
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