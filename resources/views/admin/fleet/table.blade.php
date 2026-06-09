<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Bags</th>
                    <th>Passengers</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fleets as $fleet)
                    <tr>
                        <td>
                            <img src="{{ $fleet->image_url }}" width="60" height="40" style="object-fit: cover;">
                        </td>

                        <td>
                            <strong>{{ $fleet->title }}</strong>
                            <br><small class="text-muted">/{{ $fleet->slug }}</small>
                        </td>

                        <td>{{ $fleet->bags }}</td>

                        <td>{{ $fleet->passengers }}</td>

                        <td>
                            <input type="number" name="order_level" value="{{ $fleet->order_level }}" 
                                   data-id="{{ $fleet->id }}" class="form-control form-control-sm order-level-input" style="width: 60px;">
                        </td>

                        <td>
                            <form class="status-form" data-id="{{ $fleet->id }}">
                                @csrf
                                <input type="hidden" name="status_id" value="{{ $fleet->id }}">
                                <input type="checkbox" {{ $fleet->status ? 'checked' : '' }} 
                                       data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm">
                            </form>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm">

                                <a href="{{ route('admin.fleet.edit', $fleet->id) }}" class="btn btn-primary text-light"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete(event, 'deleteForm{{ $fleet->id }}')"><i class="bi bi-trash"></i></button>
                            </div>
                            <form action="{{ route('admin.fleet.destroy', $fleet->id) }}" method="POST" id="deleteForm{{ $fleet->id }}" style="display: none;">@csrf @method('DELETE')</form>
                        </td>
                        
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted">No fleets found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($fleets->hasPages())
        <nav class="d-flex justify-content-end mt-3">{{ $fleets->appends($filters ?? [])->links() }}</nav>
    @endif
</div>