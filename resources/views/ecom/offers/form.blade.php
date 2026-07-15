@extends('layouts.app')
@section('title', isset($offer) ? 'Edit Offer' : 'Create Offer')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Offers" subTitle="{{ isset($offer) ? 'Update' : 'Create' }}" :breadcrumbItems="['Dashboard', 'E-Commerce', 'Offers']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-percent me-2"></i> {{ isset($offer) ? 'Update' : 'Create' }} Offer</h6>
            <a href="{{ route('ecom.offer.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="offerForm" method="POST" action="{{ isset($offer) ? route('ecom.offer.update', $offer->id) : route('ecom.offer.store') }}">
                @csrf
                @if(isset($offer)) @method('PUT') @endif

                <div class="row g-3">
                   
                    
                    <div class="col-lg-8">
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Offer Details</h5>

                       
                                <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                                    <i class="bi bi-lightbulb me-2"></i>
                                    <strong>How to configure this offer:</strong>
                                    <div class="small mt-2">
                                        <strong>1. Offer Type:</strong> Choose the discount logic:
                                        <ul class="mb-1 ps-3">
                                            <li><b>Buy X Get Y Free:</b> Customer buys X items, gets Y items free (e.g., Buy 2 Get 1 Free).</li>
                                            <li><b>Buy X Get Discount:</b> Customer buys X items, gets a discount on them (e.g., Buy 2 Get 20% Off).</li>
                                            <li><b>Percentage / Flat Discount:</b> Apply a % or fixed $ amount off the price.</li>
                                            <li><b>Free Shipping:</b> Waive delivery charges completely.</li>
                                        </ul>
                                        <strong>2. Apply On:</strong> 
                                        <ul class="mb-0 ps-3">
                                            <li><b>All Products:</b> Offer applies to the entire store.</li>
                                            <li><b>Specific Products / Categories:</b> Selecting this will reveal the selection lists below to pick exactly which items get the discount.</li>
                                        </ul>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <div class="row g-3">
                                    <x-input-field type="text" name="name" label="Offer Name" :value="old('name', $offer->name ?? '')" cols="col-12" required placeholder="e.g., Buy 2 Get 1 Free Summer Sale"/>
                                    <x-input-field type="textarea" name="description" label="Description" :value="old('description', $offer->description ?? '')" cols="col-12" rows="2"/>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Offer Type</label>
                                        <select name="offer_type" id="offerType" class="form-select" required>
                                            <option value="">Select Type</option>
                                            <option value="buy_x_get_y_free" {{ old('offer_type', $offer->offer_type ?? '') == 'buy_x_get_y_free' ? 'selected' : '' }}>Buy X Get Y Free</option>
                                            <option value="buy_x_get_discount" {{ old('offer_type', $offer->offer_type ?? '') == 'buy_x_get_discount' ? 'selected' : '' }}>Buy X Get Discount</option>
                                            <option value="percentage_discount" {{ old('offer_type', $offer->offer_type ?? '') == 'percentage_discount' ? 'selected' : '' }}>Percentage Discount</option>
                                            <option value="flat_discount" {{ old('offer_type', $offer->offer_type ?? '') == 'flat_discount' ? 'selected' : '' }}>Flat Discount</option>
                                            <option value="free_shipping" {{ old('offer_type', $offer->offer_type ?? '') == 'free_shipping' ? 'selected' : '' }}>Free Shipping</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Apply On</label>
                                        <select name="apply_on" id="applyOn" class="form-select" required>
                                            <option value="all_products" {{ old('apply_on', $offer->apply_on ?? 'all_products') == 'all_products' ? 'selected' : '' }}>All Products</option>
                                            <option value="specific_products" {{ old('apply_on', $offer->apply_on ?? '') == 'specific_products' ? 'selected' : '' }}>Specific Products</option>
                                            <option value="specific_categories" {{ old('apply_on', $offer->apply_on ?? '') == 'specific_categories' ? 'selected' : '' }}>Specific Categories</option>
                                        </select>
                                    </div>

                                    <div class="col-12 buyXSection" style="display:none;">
                                        <div class="row g-3 p-3 bg-light rounded">
                                            <x-input-field type="number" name="buy_quantity" label="Buy Quantity (X)" :value="old('buy_quantity', $offer->buy_quantity ?? '1')" cols="col-md-4" min="1"/>
                                            <x-input-field type="number" name="get_quantity" label="Get Quantity (Y) Free" :value="old('get_quantity', $offer->get_quantity ?? '0')" cols="col-md-4" min="0"/>
                                        </div>
                                    </div>

                                    <div class="col-12 discountSection" style="display:none;">
                                        <x-input-field type="number" name="discount_value" label="Discount Value" :value="old('discount_value', $offer->discount_value ?? '')" cols="col-md-6" step="0.01"/>
                                    </div>
                                </div>

                                <div id="productSelection" style="display:none;" class="mt-4">
                                    <h5 class="card-title mb-3 border-bottom pb-2">Select Products</h5>
                                    <div class="scrollable-container p-3" style="max-height: 300px; overflow-y: auto;">
                                        @foreach($products as $product)
                                            <div class="form-check mb-1">
                                                <input type="checkbox" class="form-check-input" name="product_ids[]" id="prod-{{ $product->id }}" value="{{ $product->id }}" {{ in_array($product->id, old('product_ids', $offer->product_ids ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="prod-{{ $product->id }}">{{ $product->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div id="categorySelection" style="display:none;" class="mt-4">
                                    <h5 class="card-title mb-3 border-bottom pb-2">Select Categories</h5>
                                    <div class="scrollable-container p-3" style="max-height: 300px; overflow-y: auto;">
                                        @foreach($categories as $category)
                                            <div class="form-check mb-1">
                                                <input type="checkbox" class="form-check-input" name="category_ids[]" id="cat-{{ $category->id }}" value="{{ $category->id }}" {{ in_array($category->id, old('category_ids', $offer->category_ids ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="cat-{{ $category->id }}">{{ $category->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                 
                    <div class="col-lg-4">
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Validity & Limits</h5>

                          

                                <div class="row g-3">
                                    <x-input-field type="date" name="start_date" label="Start Date" :value="old('start_date', isset($offer) && $offer->start_date ? $offer->start_date->format('Y-m-d') : '')" cols="col-12"/>
                                    <x-input-field type="date" name="end_date" label="End Date" :value="old('end_date', isset($offer) && $offer->end_date ? $offer->end_date->format('Y-m-d') : '')" cols="col-12"/>
                                    <x-input-field type="number" name="min_order_amount" label="Min Order Amount" :value="old('min_order_amount', $offer->min_order_amount ?? '')" cols="col-12" step="0.01"/>
                                    <x-input-field type="number" name="max_uses" label="Max Total Uses" :value="old('max_uses', $offer->max_uses ?? '')" cols="col-md-6"/>
                                    <x-input-field type="number" name="max_uses_per_user" label="Max Uses/User" :value="old('max_uses_per_user', $offer->max_uses_per_user ?? '1')" cols="col-md-6"/>
                                    <x-input-field type="number" name="priority" label="Priority" :value="old('priority', $offer->priority ?? '0')" cols="col-12" min="0"/>
                                </div>

                                <div class="mt-4 pt-3 border-top">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ old('status', $offer->status ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status">Active</label>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary w-100 py-2"><i class="bi bi-save me-2"></i> {{ isset($offer) ? 'Update' : 'Create' }} Offer</button>
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
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        function toggleSections() {
            const type = $('#offerType').val();
            const applyOn = $('#applyOn').val();
            $('.buyXSection').toggle(['buy_x_get_y_free', 'buy_x_get_discount'].includes(type));
            $('.discountSection').toggle(['buy_x_get_discount', 'percentage_discount', 'flat_discount'].includes(type));
            $('#productSelection').toggle(applyOn === 'specific_products');
            $('#categorySelection').toggle(applyOn === 'specific_categories');
        }
        $('#offerType, #applyOn').on('change', toggleSections);
        toggleSections();

        $('#offerForm').on('submit', function(e) {
            e.preventDefault();
            $('.text-danger').remove(); $('.is-invalid').removeClass('is-invalid');
            const formData = new FormData(this);
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Processing...');

            $.ajax({
                type: 'POST', url: $(this).attr('action'), data: formData, contentType: false, processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: (res) => { toastr.success(res.message); setTimeout(() => window.location.href = '{{ route("ecom.offer.index") }}', 1000); },
                error: (xhr) => {
                    submitBtn.prop('disabled', false).html(originalText);
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, (field, errors) => {
                            $('[name="' + field + '"]').first().addClass('is-invalid').after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
                        });
                        toastr.error('Please fix the errors');
                    } else toastr.error('Something went wrong');
                }
            });
        });
    });
</script>
@endpush