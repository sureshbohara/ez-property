@extends('layouts.app')

@section('title', 'Email Marketing')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Marketing" subTitle="Bulk Email" :breadcrumbItems="['Dashboard', 'Marketing']"/>

    <div class="row g-4">
        

        <div class="col-lg-5">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
                    <h6 class="mb-0"><i class="bi bi-envelope-paper"></i> Compose Email</h6>
                    <span class="badge bg-light text-dark">Summernote</span>
                </div>
                <div class="card-body">
                    <form id="emailForm">
                        @csrf
                        <div class="mb-3">
                            <x-input-field 
                                type="text" 
                                name="subject" 
                                label="Email Subject" 
                                placeholder="e.g. Summer Sale 2024" 
                                required 
                            />
                        </div>
                        
               
                        <div class="mb-3">
                            <label class="form-label fw-bold">Message Content</label>
                            <textarea name="content" class="editor form-control" rows="10" required placeholder="Write your message here..."></textarea>
                            <small class="text-muted">Images are auto-uploaded via your existing settings.</small>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2">
                            <i class="bi bi-send-fill"></i> Send to All Subscribers
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right: Subscriber List --}}
        <div class="col-lg-7">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
                    <h6 class="mb-0"><i class="bi bi-people-fill"></i> Subscriber List</h6>
                    <span class="badge bg-light text-dark">{{ $subscribers->total() }} Total</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Email Address</th>
                                    <th>Subscribed Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subscribers as $sub)
                                <tr>
                                    <td>{{ $sub->id }}</td>
                                    <td>{{ $sub->email }}</td>
                                    <td>{{ $sub->subscribed_at->format('d M, Y') }}</td>
                                    <td>
                                        @if($sub->is_subscribed)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No subscribers found yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($subscribers->hasPages())
                        <div class="p-3">{{ $subscribers->links() }}</div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#emailForm').on('submit', function(e) {
            e.preventDefault();
            if(!confirm('Are you sure you want to send this email to all subscribers?')) return;
            const btn = $(this).find('button[type="submit"]');
            const originalText = btn.html();
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Sending...');
            $('.editor').val($('.editor').summernote('code'));
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.marketing.send') }}",
                data: $(this).serialize(), 
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    toastr.success(response.message);
                    $('#emailForm')[0].reset();
                    $('.editor').summernote('code', ''); 
                    btn.prop('disabled', false).html(originalText);
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Error sending email.');
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });
    });
</script>
@endpush