<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="80">Image</th>
                    <th>Name</th>
                    <th>Rating</th>
                    <th>Display On</th>
                    <th width="80">Order</th>
                    <th width="100">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>

                    <td>
                        <img src="{{ $review->image_url }}" width="60" height="40" style="object-fit: cover;">
                    </td>

                    <td>
                        <strong>{{ $review->name }}</strong><br>
                        <small class="text-muted">{{ Str::limit($review->email, 20) }}</small>
                    </td>

                    <td>
                        <span class="badge bg-warning text-dark">
                            {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                        </span>
                    </td>

                    <td>{{ ucfirst($review->display_on) }}</td>

                    <td>
                        <input type="number" name="order_level"
                        value="{{ $review->order_level }}"
                        data-id="{{ $review->id }}"
                        class="form-control form-control-sm order-level-input"
                        style="width: 60px;">
                    </td>

                    <td>
                        <form class="status-form" data-id="{{ $review->id }}">
                            @csrf
                            <input type="hidden" name="status_id" value="{{ $review->id }}">
                            <input type="checkbox" {{ $review->status ? 'checked' : '' }}
                            data-toggle="toggle"
                            data-onstyle="success"
                            data-offstyle="danger"
                            data-size="sm">
                        </form>
                    </td>

                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.review.edit', $review->id) }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(event, 'deleteForm{{ $review->id }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <form action="{{ route('admin.review.destroy', $review->id) }}" method="POST" id="deleteForm{{ $review->id }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                    
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">No reviews found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reviews->hasPages())
    <nav class="d-flex justify-content-end mt-3">
        {{ $reviews->appends($filters ?? [])->links() }}
    </nav>
    @endif
</div>