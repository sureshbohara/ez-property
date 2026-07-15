@extends('layouts.app')
@section('title', isset($productAttribute) ? 'Edit Attribute' : 'Create Attribute')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Product Attributes" subTitle="{{ isset($productAttribute) ? 'Update' : 'Create' }}" :breadcrumbItems="['Dashboard', 'E-Commerce', 'Attributes']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-sliders me-2"></i> {{ isset($productAttribute) ? 'Update' : 'Create' }} Attribute</h6>
            <a href="{{ route('ecom.product-attribute.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="attrForm" method="POST" action="{{ isset($productAttribute) ? route('ecom.product-attribute.update', $productAttribute->id) : route('ecom.product-attribute.store') }}">
                @csrf
                @if(isset($productAttribute)) @method('PUT') @endif
                <div class="row g-3">
                    <div class="col-lg-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                
                            
                                <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                                    <i class="bi bi-lightbulb me-2"></i>
                                    <strong>How to configure product attributes (with examples):</strong>
                                    <div class="small mt-2">
                                        <strong>1. Attribute Name & Type:</strong>
                                        <ul class="mb-1 ps-3">
                                            <li><b>Dropdown Select:</b> Standard dropdown menu. <br>
                                                <em class="text-muted">Example: Size (S, M, L, XL), Material (Cotton, Polyester, Silk)</em>
                                            </li>
                                            <li><b>Color Swatches:</b> Visual color circles. <br>
                                                <em class="text-muted">Example: Red, Blue, Green - customers see actual color circles instead of text</em>
                                            </li>
                                            <li><b>Text Input:</b> Free text field for custom input. <br>
                                                <em class="text-muted">Example: Engraving text, Custom message, Personalization</em>
                                            </li>
                                            <li><b>Image:</b> Visual image selection. <br>
                                                <em class="text-muted">Example: Pattern (Stripes, Plaid, Solid), Design (Floral, Geometric)</em>
                                            </li>
                                        </ul>
                                        <strong>2. Attribute Values:</strong> 
                                        <ul class="mb-1 ps-3">
                                            <li>Add all possible options customers can choose from.</li>
                                            <li><em class="text-muted">Example for Size: S, M, L, XL, XXL</em></li>
                                            <li><em class="text-muted">Example for Color: Red (#FF0000), Blue (#0000FF), Green (#00FF00)</em></li>
                                        </ul>
                                        <strong>3. Display Order:</strong> 
                                        <ul class="mb-0 ps-3">
                                            <li>Controls the order attributes appear on the product page.</li>
                                            <li><em class="text-muted">Example: Set Size to 1, Color to 2 - Size will show first</em></li>
                                        </ul>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <div class="row g-3">
                                    <x-input-field type="text" name="name" label="Attribute Name" :value="old('name', $productAttribute->name ?? '')" cols="col-md-6" required placeholder="e.g., Size, Color"/>
                                  
                                    
                                    <x-input-field type="text" name="slug" label="Slug" :value="old('slug', $productAttribute->slug ?? '')" cols="col-md-6" placeholder="auto-generated"/>
                                   
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Type</label>
                                        <select name="type" class="form-select" required>
                                            <option value="">Select Type</option>
                                            <option value="select" {{ old('type', $productAttribute->type ?? '') == 'select' ? 'selected' : '' }}>Dropdown Select</option>
                                            <option value="color" {{ old('type', $productAttribute->type ?? '') == 'color' ? 'selected' : '' }}>Color Swatches</option>
                                            <option value="text" {{ old('type', $productAttribute->type ?? '') == 'text' ? 'selected' : '' }}>Text Input</option>
                                            <option value="image" {{ old('type', $productAttribute->type ?? '') == 'image' ? 'selected' : '' }}>Image</option>
                                        </select>
                                        <small class="form-text text-muted">Choose how customers will select this attribute on the product page.</small>
                                    </div>
                                    
                                    <x-input-field type="number" name="order_level" label="Display Order" :value="old('order_level', $productAttribute->order_level ?? '0')" cols="col-md-6" min="0"/>
                                    <small class="form-text text-muted">Lower numbers display first. Example: 1 = first, 2 = second, etc.</small>

                                    <div class="col-12 mt-4 pt-3 border-top">
                                        <h6 class="mb-3 text-primary">Attribute Values</h6>
                                        <p class="text-muted small">Add possible values for this attribute (e.g., S, M, L, XL for Size)</p>
                                        <div class="alert alert-light border small mb-3">
                                            <i class="bi bi-info-circle me-2"></i>
                                            <strong>Tip:</strong> For <b>Color Swatches</b>, enter color names or hex codes (e.g., "Red" or "#FF0000"). For other types, enter any text value.
                                        </div>
                                        <div class="valuesDisplay">
                                            @if(isset($productAttribute) && !empty($productAttribute->values))
                                                @foreach($productAttribute->values as $value)
                                                    <div class="row mb-2 valueItem">
                                                        <div class="col-10"><input type="text" name="values[]" class="form-control" value="{{ $value }}" placeholder="Value"></div>
                                                        <div class="col-2"><button type="button" class="btn btn-danger btn-sm removeValue"><i class="bi bi-trash"></i></button></div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-custom btn-sm addValue"><i class="bi bi-plus-circle"></i> Add Value</button>
                                    </div>

                                    <div class="col-12 mt-4 pt-3 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2"><i class="bi bi-save me-2"></i> {{ isset($productAttribute) ? 'Update' : 'Create' }}</button>
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
        $('.addValue').click(() => $('.valuesDisplay').append(`<div class="row mb-2 valueItem"><div class="col-10"><input type="text" name="values[]" class="form-control" placeholder="Value"></div><div class="col-2"><button type="button" class="btn btn-danger btn-sm removeValue"><i class="bi bi-trash"></i></button></div></div>`));
        $(document).on('click', '.removeValue', function() { $(this).closest('.valueItem').remove(); });

        $('#attrForm').on('submit', function(e) {
            e.preventDefault();
            $('.text-danger').remove(); $('.is-invalid').removeClass('is-invalid');
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
                    setTimeout(() => window.location.href = '{{ route("ecom.product-attribute.index") }}', 1000); 
                },
                error: (xhr) => {
                    submitBtn.prop('disabled', false).html(originalText);
                    console.log('Error Response:', xhr.responseJSON); 
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, (field, errors) => {
                            $('[name="' + field + '"], [name="' + field + '[]"]').first().addClass('is-invalid').after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
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