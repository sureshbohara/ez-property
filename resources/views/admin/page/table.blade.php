<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Short Content</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                <tr>
                    <td><img src="{{ $page->image_url }}" width="60" height="40" style="object-fit: cover; border-radius: 4px;"></td>

                    <td>
                        <strong>{{ $page->title }}</strong><br>
                        <small class="text-muted">
                            @if($page->show_in_menu) <span class="badge bg-info">Menu</span> @endif
                            @if($page->show_in_footer) <span class="badge bg-secondary">Footer</span> @endif
                            @if($page->is_featured) <span class="badge bg-warning text-dark">Featured</span> @endif
                        </small>
                    </td>

                    <td><small>{{ Str::limit(strip_tags($page->short_content), 60) }}</small></td>

    

                    <td>
                        <input type="number" name="order_level" value="{{ $page->order_level }}" data-id="{{ $page->id }}" data-original="{{ $page->order_level }}" class="form-control form-control-sm order-level-input" style="width: 70px;">
                    </td>

                    <td>
                        <form class="status-form" data-id="{{ $page->id }}">
                            @csrf
                            <input type="hidden" name="status_id" value="{{ $page->id }}">
                            <input type="checkbox" {{ $page->status ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm" data-width="50">
                        </form>
                    </td>

                    <td>
                        <div class="btn-group btn-group-sm">

                  

                            <a href="{{ route('admin.page.edit', $page->id) }}" class="btn btn-primary text-light" title="Edit"><i class="bi bi-pencil"></i></a>

                            <button type="button" class="btn btn-danger" onclick="confirmDelete(event, 'deleteForm{{ $page->id }}')" title="Delete"><i class="bi bi-trash"></i></button>

                        </div>
                        <form action="{{ route('admin.page.destroy', $page->id) }}" method="POST" id="deleteForm{{ $page->id }}" style="display: none;">@csrf @method('DELETE')</form>
                    </td>

                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">No pages found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pages->hasPages())
    <nav class="d-flex justify-content-end mt-3">{{ $pages->appends(request()->except('page'))->links() }}</nav>
    @endif
</div>