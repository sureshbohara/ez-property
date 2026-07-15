@extends('layouts.app')
@section('title', isset($coupon) ? 'Edit Coupon' : 'Create Coupon')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Coupons" subTitle="{{ isset($coupon) ? 'Update' : 'Create' }}" :breadcrumbItems="['Dashboard', 'E-Commerce', 'Coupons']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-ticket-perforated me-2"></i> {{ isset($coupon) ? 'Update' : 'Create' }} Coupon</h6>
            <a href="{{ route('ecom.coupon.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="couponForm" method="POST" action="{{ isset($coupon) ? route('ecom.coupon.update', $coupon->id) : route('ecom.coupon.store') }}">
                @csrf
                @if(isset($coupon)) @method('PUT') @endif

                <div class="row g-3">
                    {{-- ========================================== --}}
                    {{-- LEFT SIDE (COL 8): COUPON DETAILS --}}
                    {{-- ========================================== --}}
                    <div class="col-lg-8">
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Coupon Details</h5>

                                {{-- DETAILED INSTRUCTION WITH EXAMPLES --}}
                                <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                                    <i class="bi bi-lightbulb me-2"></i>
                                    <strong>How to configure this coupon (with examples):</strong>
                                    <div class="small mt-2">
                                        <strong>1. Discount Type & Value:</strong>
                                        <ul class="mb-1 ps-3">
                                            <li><b>Fixed Amount ($):</b> Deducts a specific dollar amount. <br>
                                                <em class="text-muted">Example: If you enter <b>$10</b>, the customer gets exactly $10 off their cart.</em>
                                            </li>
                                            <li><b>Percentage (%):</b> Deducts a percentage of the cart total. <br>
                                                <em class="text-muted">Example: If you enter <b>20%</b> and the cart is $100, the customer gets $20 off.</em>
                                            </li>
                                        </ul>
                                        <strong>2. Conditions & Limits:</strong> 
                                        <ul class="mb-0 ps-3">
                                            <li><b>Min Order Amount:</b> The minimum cart subtotal required for the coupon to work. <br>
                                                <em class="text-muted">Example: If set to <b>$50</b>, the coupon only applies if the customer's cart is $50 or more.</em>
                                            </li>
                                            <li><b>Max Discount (for % only):</b> Caps the maximum discount amount for percentage coupons. <br>
                                                <em class="text-muted">Example: If you set <b>50% off</b> with a max discount of <b>$20</b>, and the cart is $100 (50% = $50), the customer only gets $20 off.</em>
                                            </li>
                                        </ul>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <div class="row g-3">
                                    <x-input-field type="text" name="code" label="Coupon Code" :value="old('code', $coupon->code ?? '')" cols="col-md-6" required placeholder="e.g., SUMMER20"/>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Discount Type</label>
                                        <select name="discount_type" class="form-select" required>
                                            <option value="fixed" {{ old('discount_type', $coupon->discount_type ?? 'fixed') == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                                            <option value="percentage" {{ old('discount_type', $coupon->discount_type ?? '') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                        </select>
                                        <small class="form-text text-muted">Choose whether to deduct a fixed dollar amount or a percentage from the cart.</small>
                                    </div>

                                    <div class="col-md-6">
                                        <x-input-field type="number" name="discount_value" label="Discount Value" :value="old('discount_value', $coupon->discount_value ?? '')" cols="col-12" step="0.01" required/>
                                        <small class="form-text text-muted">Enter the amount (e.g., 10 for $10 off) or percentage (e.g., 20 for 20% off).</small>
                                    </div>

                                    <div class="col-md-6">
                                        <x-input-field type="number" name="min_order_amount" label="Min Order Amount" :value="old('min_order_amount', $coupon->min_order_amount ?? '')" cols="col-12" step="0.01"/>
                                        <small class="form-text text-muted">Minimum cart total required to use this coupon. Leave blank for no minimum.</small>
                                    </div>

                                    <div class="col-md-12">
                                        <x-input-field type="number" name="max_discount" label="Max Discount (for % only)" :value="old('max_discount', $coupon->max_discount ?? '')" cols="col-12" step="0.01"/>
                                        <small class="form-text text-muted">Only for percentage discounts. Caps the maximum discount amount. Example: 50% off, but max $20 discount.</small>
                                    </div>
                                    
                                    <x-input-field type="textarea" name="description" label="Description" :value="old('description', $coupon->description ?? '')" cols="col-12" rows="2"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Validity & Limits</h5>

                                <div class="alert alert-light border alert-dismissible fade show mb-3" role="alert">
                                    <i class="bi bi-shield-check me-2 text-success"></i>
                                    <strong>Quick Tips:</strong> Leave dates blank for a coupon that never expires. Use 'Total Usage Limit' to cap overall redemptions, and 'Per User Limit' to prevent abuse.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <div class="row g-3">
                                    <x-input-field type="date" name="start_date" label="Start Date" :value="old('start_date', isset($coupon) && $coupon->start_date ? $coupon->start_date->format('Y-m-d') : '')" cols="col-12"/>
                                    <x-input-field type="date" name="end_date" label="End Date" :value="old('end_date', isset($coupon) && $coupon->end_date ? $coupon->end_date->format('Y-m-d') : '')" cols="col-12"/>

                                    <x-input-field type="number" name="usage_limit" label="Total Usage Limit" :value="old('usage_limit', $coupon->usage_limit ?? '')" cols="col-md-12"/>

                                    <x-input-field type="number" name="usage_limit_per_user" label="Per User Limit" :value="old('usage_limit_per_user', $coupon->usage_limit_per_user ?? '1')" cols="col-md-12"/>
                                </div>

                                <div class="mt-4 pt-3 border-top">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ old('status', $coupon->status ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status">Active</label>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary w-100 py-2"><i class="bi bi-save me-2"></i> {{ isset($coupon) ? 'Update' : 'Create' }} Coupon</button>
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
        $('#couponForm').on('submit', function(e) {
            e.preventDefault();
            $('.text-danger').remove(); $('.is-invalid').removeClass('is-invalid');
            const formData = new FormData(this);
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Processing...');

            $.ajax({
                type: 'POST', url: $(this).attr('action'), data: formData, contentType: false, processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: (res) => { toastr.success(res.message); setTimeout(() => window.location.href = '{{ route("ecom.coupon.index") }}', 1000); },
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