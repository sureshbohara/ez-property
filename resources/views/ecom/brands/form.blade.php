@extends('layouts.app')
@section('title', isset($brand) ? 'Edit Brand' : 'Create Brand')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Brands" subTitle="{{ isset($brand) ? 'Update Brand' : 'Create Brand' }}" :breadcrumbItems="['Dashboard', 'E-Commerce', 'Brands']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-bookmark me-2"></i> {{ isset($brand) ? 'Update Brand' : 'Create Brand' }}</h6>
            <a href="{{ route('ecom.brand.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="brandForm" method="POST" enctype="multipart/form-data" action="{{ isset($brand) ? route('ecom.brand.update', $brand->id) : route('ecom.brand.store') }}">
                @csrf
                @if(isset($brand)) @method('PUT') @endif

                <div class="row g-3">
                
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                
                              
                                <h5 class="card-title mb-3 border-bottom pb-2">Brand Details</h5>
                                <div class="row g-3">
                                    <x-input-field type="text" name="name" label="Brand Name" :value="old('name', $brand->name ?? '')" cols="col-md-12" required placeholder="e.g., Nike, Adidas, Puma"/>
                                  
                                    
                                    <x-input-field type="text" name="website" label="Official Website" :value="old('website', $brand->website ?? '')" cols="col-md-6" placeholder="https://www.nike.com"/>
                                        
                                    <x-input-field type="number" name="order_level" label="Display Order" :value="old('order_level', $brand->order_level ?? '0')" cols="col-md-6" min="0" placeholder="0 = Highest priority"/>

                                    <x-input-field type="textarea" name="description" label="Description" :value="old('description', $brand->description ?? '')" cols="col-12" rows="4" placeholder="Brief description about the brand, its history, and product range..."/>

                                 
                                    <div class="col-12 mt-4 pt-3 border-top">
                                        <h6 class="mb-3 text-primary"> SEO Settings</h6>
                                        <div class="row g-3">
                                            <x-input-field type="text" name="meta_title" label="Meta Title" :value="old('meta_title', $brand->meta_title ?? '')" cols="col-12" placeholder="Brand Name - Your Store"/>
                                        
                                            <x-input-field type="textarea" name="meta_description" label="Meta Description" :value="old('meta_description', $brand->meta_description ?? '')" cols="col-12" rows="2" placeholder="Brief description for search engines (max 160 characters)"/>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

               
                    <div class="col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                
                             
                                <h5 class="card-title mb-3 border-bottom pb-2">Brand Logo</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Upload Logo</label>
                                        <input type="file" name="logo" class="form-control" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'logoPreview')">
                                        <small class="text-muted">Recommended: 300x150px, PNG with transparent background</small>
                                        <div class="text-center mt-3 p-3 bg-light rounded">
                                            <img src="{{ isset($brand) && $brand->logo_url ? $brand->logo_url : asset('default/noimage.png') }}" 
                                                 class="img-fluid border" 
                                                 id="logoPreview" 
                                                 style="max-height: 120px; object-fit: contain;">
                                        </div>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="mt-4 pt-3 border-top">
                                    <h6 class="mb-3">Status</h6>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ old('status', $brand->status ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status">Active (Visible on website)</label>
                                    </div>
                                </div>

                                {{-- Submit Button --}}
                                <div class="mt-4 pt-3 border-top">
                                    <button type="submit" class="btn btn-primary w-100 py-2">
                                        <i class="bi bi-save me-2"></i> {{ isset($brand) ? 'Update' : 'Create' }} Brand
                                    </button>
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
        $('#brandForm').on('submit', function(e) {
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
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(res) { 
                    toastr.success(res.message); 
                    setTimeout(() => window.location.href = '{{ route("ecom.brand.index") }}', 1000); 
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html(originalText);
                    console.error('Error:', xhr.responseJSON);
                    
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            $('[name="' + field + '"]').first()
                                .addClass('is-invalid')
                                .after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
                        });
                        toastr.error('Please fix the errors');
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                    }
                }
            });
        });
    });
</script>
@endpush