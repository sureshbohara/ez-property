<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="60">Icon</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th width="80">Order</th>
                    <th width="90">Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($amenities as $amenity)
                    <tr>
                        <td class="text-center fs-4">
                            @if($amenity->icon) <i class="{{ $amenity->icon }} text-primary"></i>
                            @else <i class="bi bi-circle text-muted"></i> @endif
                        </td>
                        <td><strong>{{ $amenity->name }}</strong></td>
                        <td><small class="text-muted">{{ Str::limit($amenity->description, 50) }}</small></td>
                        <td>
                            <input type="number" value="{{ $amenity->order_level }}" data-id="{{ $amenity->id }}" class="form-control form-control-sm order-level-input" style="width: 70px;">
                        </td>
                        <td>
                            <form class="status-form" data-id="{{ $amenity->id }}">
                                @csrf <input type="hidden" name="status_id" value="{{ $amenity->id }}">
                                <input type="checkbox" {{ $amenity->status ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm">
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('listing.amenity.edit', $amenity->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(event, 'deleteForm{{ $amenity->id }}')"><i class="bi bi-trash"></i></button>
                            </div>
                            <form action="{{ route('listing.amenity.destroy', $amenity->id) }}" method="POST" id="deleteForm{{ $amenity->id }}" style="display: none;">@csrf @method('DELETE')</form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No amenities found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($amenities->hasPages())
        <nav class="d-flex justify-content-end mt-3">{{ $amenities->appends($filters ?? [])->links() }}</nav>
    @endif
</div>