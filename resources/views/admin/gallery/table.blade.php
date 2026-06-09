<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="100">Image</th>
                    <th>Name</th>
                    <th>Display On</th>
                    <th>Alt Text</th>
                    <th width="80">Order</th>
                    <th width="100">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galleries as $gallery)
                    <tr>

                        <td>
                            <img src="{{ $gallery->image_url }}" width="80" height="60" style="object-fit: cover;">
                        </td>

                        <td><strong>{{ $gallery->name }}</strong></td>

                        <td>{{ ucfirst($gallery->display_on) }}</td>

                        <td>{{ $gallery->alt ?? '-' }}</td>

                        <td>
                            <input type="number" name="order_level"
                                   value="{{ $gallery->order_level }}"
                                   data-id="{{ $gallery->id }}"
                                   class="form-control form-control-sm order-level-input"
                                   style="width: 60px;">
                        </td>

                        <td>
                            <form class="status-form" data-id="{{ $gallery->id }}">
                                @csrf
                                <input type="hidden" name="status_id" value="{{ $gallery->id }}">
                                <input type="checkbox" {{ $gallery->status ? 'checked' : '' }}
                                       data-toggle="toggle"
                                       data-onstyle="success"
                                       data-offstyle="danger"
                                       data-size="sm">
                            </form>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm">

                                <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="btn btn-primary text-light">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete(event, 'deleteForm{{ $gallery->id }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" id="deleteForm{{ $gallery->id }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No gallery images found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($galleries->hasPages())
        <nav class="d-flex justify-content-end mt-3">
            {{ $galleries->appends($filters ?? [])->links() }}
        </nav>
    @endif
</div>