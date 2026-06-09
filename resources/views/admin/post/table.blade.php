<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Views</th>
                    <th>Order</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td><img src="{{ $post->image_url }}" width="60" height="40" style="object-fit: cover; border-radius: 4px;"></td>

                    <td>
                        <strong>{{ $post->title }}</strong><br>
                        <small class="text-muted">{{ $post->slug }}</small>
                    </td>

                    <td>
                        @if($post->category)
                            <span class="badge bg-primary">{{ $post->category->name }}</span>
                        @else
                            <span class="badge bg-secondary">Uncategorized</span>
                        @endif
                    </td>

    
                    
                    <td><span class="badge bg-info text-dark">{{ $post->views }}</span></td>

                    <td>
                        <input type="number" name="order_level" value="{{ $post->order_level }}" data-id="{{ $post->id }}" data-original="{{ $post->order_level }}" class="form-control form-control-sm order-level-input" style="width: 70px;">
                    </td>

                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input featured-toggle" type="checkbox" {{ $post->is_featured ? 'checked' : '' }} data-id="{{ $post->id }}">
                        </div>
                    </td>

                    <td>
                        <form class="status-form" data-id="{{ $post->id }}">
                            @csrf
                            <input type="hidden" name="status_id" value="{{ $post->id }}">
                            <input type="checkbox" {{ $post->status === 'active' ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm" data-width="50">
                        </form>
                    </td>

                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.post.edit', $post->id) }}" class="btn btn-primary text-light" title="Edit"><i class="bi bi-pencil"></i></a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete(event, 'deleteForm{{ $post->id }}')" title="Delete"><i class="bi bi-trash"></i></button>
                        </div>
                        <form action="{{ route('admin.post.destroy', $post->id) }}" method="POST" id="deleteForm{{ $post->id }}" style="display: none;">@csrf @method('DELETE')</form>
                    </td>

                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-4 text-muted">No posts found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($posts->hasPages())
    <nav class="d-flex justify-content-end mt-3">{{ $posts->appends(request()->except('page'))->links() }}</nav>
    @endif
</div>