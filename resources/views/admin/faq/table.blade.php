<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th>Question</th>
                    <th>Display On</th>
                    <th width="80">Order</th>
                    <th width="100">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                    <tr>

                        <td>
                            <strong>{{ Str::limit($faq->question, 60) }}</strong>
                            <br><small class="text-muted">{{ Str::limit(strip_tags($faq->answer), 40) }}</small>
                        </td>

                        <td>{{ ucfirst($faq->display_on) }}</td>

                        <td>
                            <input type="number" name="order_level" value="{{ $faq->order_level }}" 
                                   data-id="{{ $faq->id }}" class="form-control form-control-sm order-level-input" style="width: 60px;">
                        </td>

                        <td>
                            <form class="status-form" data-id="{{ $faq->id }}">
                                @csrf
                                <input type="hidden" name="status_id" value="{{ $faq->id }}">
                                <input type="checkbox" {{ $faq->status ? 'checked' : '' }} 
                                       data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm">
                            </form>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.faq.edit', $faq->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(event, 'deleteForm{{ $faq->id }}')"><i class="bi bi-trash"></i></button>
                            </div>
                            <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST" id="deleteForm{{ $faq->id }}" style="display: none;">@csrf @method('DELETE')</form>
                        </td>
                        
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">No FAQs found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($faqs->hasPages())
        <nav class="d-flex justify-content-end mt-3">{{ $faqs->appends($filters ?? [])->links() }}</nav>
    @endif
</div>