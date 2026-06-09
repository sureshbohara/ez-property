@extends('layouts.app')

@section('title', isset($review) ? 'Edit Review' : 'Create Review')

@section('content')
<main class="page-content">
    <x-breadcrumb
        title="Manage Reviews"
        subTitle="{{ isset($review) ? 'Update Review' : 'Create Review' }}"
        :breadcrumbItems="['Dashboard', 'Reviews']"
    />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-chat-square-text me-2"></i>
                {{ isset($review) ? 'Update Review' : 'Create Review' }}
            </h6>
            <a href="{{ route('admin.review.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="reviewForm" method="POST" enctype="multipart/form-data"
                  action="{{ isset($review) ? route('admin.review.update', $review->id) : route('admin.review.store') }}">
                @csrf
                @if(isset($review)) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Review Details</h5>
                                <div class="row g-3">

                                    <x-input-field type="text" name="name" label="Customer Name" :value="old('name', $review->name ?? '')" cols="col-6" required placeholder="e.g., John Doe"/>
                                    <x-input-field type="email" name="email" label="Email" :value="old('email', $review->email ?? '')" cols="col-6" placeholder="e.g., john@example.com"/>

                                    <x-input-field type="text" name="address" label="Location" :value="old('address', $review->address ?? '')" cols="col-12" placeholder="e.g., New York, USA"/>
                                    
                    
                                    <x-input-field type="textarea" name="review" label="Short Review" :value="old('review', $review->review ?? '')" cols="col-12" rows="2" required placeholder="Brief summary of the review"/>

                                    <x-input-field type="textarea" name="content" label="Detailed Content" :value="old('content', $review->content ?? '')" cols="col-12" rows="4" editor="true" placeholder="Full review text (optional)"/>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Settings</h5>
                                <div class="row g-3">

                                     <div class="col-12">
                                        <label class="form-label fw-semibold">Rating</label>
                                        <select name="rating" class="form-select" required>
                                            @for($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}" {{ old('rating', $review->rating ?? '') == $i ? 'selected' : '' }}>
                                                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <x-input-field type="number" name="order_level" label="Display Order" :value="old('order_level', $review->order_level ?? '0')" cols="col-12" min="0" placeholder="0 = Highest priority"/>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Display On</label>
                                        <select name="display_on" class="form-select" required>
                                            <option value="homepage" {{ old('display_on', $review->display_on ?? '') == 'homepage' ? 'selected' : '' }}>🏠 Homepage</option>
                                            <option value="product" {{ old('display_on', $review->display_on ?? '') == 'product' ? 'selected' : '' }}>🛍️ Product Page</option>
                                            <option value="category" {{ old('display_on', $review->display_on ?? '') == 'category' ? 'selected' : '' }}>📂 Category Page</option>
                                            <option value="footer" {{ old('display_on', $review->display_on ?? '') == 'footer' ? 'selected' : '' }}>🔻 Footer</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Customer Photo</label>
                                        <input type="file" name="image" class="form-control" accept="image/png, image/jpeg, image/webp" onchange="previewImage(this, 'imagePreview')">
                                    </div>

                                    <div class="col-12 text-center">
                                        <img src="{{ isset($review) && $review->image_url ? $review->image_url : asset('default/noimage.png') }}" alt="Preview" class="img-fluid preview-image border" id="imagePreview" style="max-height: 120px; width: 120px; object-fit: cover;">
                                    </div>

                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2">
                                            <i class="bi bi-save me-2"></i> {{ isset($review) ? 'Update Review' : 'Create Review' }}
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
<script>
    $(document).ready(function() {
        $('#reviewForm').on('submit', function(e) {
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
                    setTimeout(() => { window.location.href = '{{ route("admin.review.index") }}'; }, 1500);
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