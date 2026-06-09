<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="80">Image</th>
                    <th>Name</th>
                    <th>Parent</th>
                    <th>Display On</th>
                    <th width="80">Order</th>
                    <th width="100">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>
                            <img src="{{ $category->image_url }}" width="60" height="40" style="object-fit: cover;">
                        </td>

                        <td><strong>{{ $category->name }}</strong><br><small class="text-muted">/{{ $category->slug }}</small></td>

                        <td>{{ $category->parent?->name ?? 'None (Root)' }}</td>

                        <td>{{ ucfirst($category->display_on) }}</td>

                        <td><input type="number" name="order_level" value="{{ $category->order_level }}" data-id="{{ $category->id }}" class="form-control form-control-sm order-level-input" style="width: 60px;"></td>

                        <td>
                            <form class="status-form" data-id="{{ $category->id }}">
                                @csrf <input type="hidden" name="status_id" value="{{ $category->id }}">
                                <input type="checkbox" {{ $category->status ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm">
                            </form>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(event, 'deleteForm{{ $category->id }}')"><i class="bi bi-trash"></i></button>
                            </div>
                            <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" id="deleteForm{{ $category->id }}" style="display: none;">@csrf @method('DELETE')</form>
                        </td>
                        
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No categories found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
        <nav class="d-flex justify-content-end mt-3">{{ $categories->appends($filters ?? [])->links() }}</nav>
    @endif
</div>