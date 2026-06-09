@extends('layouts.app')
@section('title', isset($faq) ? 'Edit FAQ' : 'Create FAQ')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage FAQs" subTitle="{{ isset($faq) ? 'Update FAQ' : 'Create FAQ' }}" :breadcrumbItems="['Dashboard', 'FAQs']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-question-circle me-2"></i>{{ isset($faq) ? 'Update FAQ' : 'Create FAQ' }}</h6>
            <a href="{{ route('admin.faq.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to List</a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="faqForm" method="POST" action="{{ isset($faq) ? route('admin.faq.update', $faq->id) : route('admin.faq.store') }}">
                @csrf
                @if(isset($faq)) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">FAQ Content</h5>
                                <div class="row g-3">

                                    <x-input-field type="text" name="question" label="Question" :value="old('question', $faq->question ?? '')" cols="col-12" required placeholder="e.g., What is your return policy?" aria-describedby="questionHelp"/>

                                    <small id="questionHelp" class="form-text text-muted mb-3">Keep questions clear and concise for better UX</small>

                                    <x-input-field type="textarea" name="answer" label="Answer" :value="old('answer', $faq->answer ?? '')" cols="col-12" rows="5" editor="true" required placeholder="Provide a helpful, detailed answer..." aria-describedby="answerHelp"/>

                                    <small id="answerHelp" class="form-text text-muted">Supports HTML • Aim for clear, scannable answers</small>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Settings</h5>
                                <div class="row g-3">

                                    <x-input-field type="number" name="order_level" label="Display Order" :value="old('order_level', $faq->order_level ?? '0')" cols="col-12" min="0" placeholder="0 = Highest priority" aria-describedby="orderHelp"/>
                                        
                                    <small id="orderHelp" class="form-text text-muted">Lower numbers appear first in lists</small>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold" for="display_on">Display On</label>
                                        <select name="display_on" id="display_on" class="form-select" required aria-describedby="displayHelp">
                                            <option value="default" {{ old('display_on', $faq->display_on ?? '') == 'default' ? 'selected' : '' }}>🌐 Default (All Pages)</option>
                                            <option value="homepage" {{ old('display_on', $faq->display_on ?? '') == 'homepage' ? 'selected' : '' }}>🏠 Homepage</option>
                                            <option value="product" {{ old('display_on', $faq->display_on ?? '') == 'product' ? 'selected' : '' }}>🛍️ Product Page</option>
                                            <option value="checkout" {{ old('display_on', $faq->display_on ?? '') == 'checkout' ? 'selected' : '' }}>🛒 Checkout</option>
                                            <option value="footer" {{ old('display_on', $faq->display_on ?? '') == 'footer' ? 'selected' : '' }}>🔻 Footer</option>
                                        </select>
                                        <small id="displayHelp" class="form-text text-muted">Controls where this FAQ appears in frontend</small>
                                    </div>


                                    <div class="col-12 mt-4 pt-3 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2">
                                            <i class="bi bi-save me-2"></i> {{ isset($faq) ? 'Update FAQ' : 'Create FAQ' }}
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
        $('#faqForm').on('submit', function(e) {
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
                    setTimeout(() => { window.location.href = '{{ route("admin.faq.index") }}'; }, 1500);
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html(originalBtnText);
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            $('[name="' + field + '"]').addClass('is-invalid')
                                .after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
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