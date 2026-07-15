<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="70">Image</th>
                    <th>Name</th>
                    <th>Duration</th>
                    <th>Price</th>
                    <th width="70">Order</th>
                    <th width="90">Status</th>
                    <th width="220">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $package)
                    <tr>
                        <td><img src="{{ $package->image_url }}" width="50" height="40" style="object-fit: cover; border-radius: 4px;"></td>
                        <td><strong>{{ $package->name }}</strong><br><small class="text-muted">/{{ $package->slug }}</small></td>
                        <td>{{ $package->duration ?? 'N/A' }}</td>
                        <td>${{ number_format($package->trip_price ?? 0, 2) }}</td>
                        <td><input type="number" value="{{ $package->order_level }}" data-id="{{ $package->id }}" class="form-control form-control-sm order-level-input" style="width: 60px;"></td>
                        <td>
                            <form class="status-form" data-id="{{ $package->id }}">
                                @csrf <input type="hidden" name="status_id" value="{{ $package->id }}">
                                <input type="checkbox" {{ $package->status ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm">
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.trip.itinerary', $package->id) }}" class="btn btn-outline-info" title="Itinerary"><i class="bi bi-map"></i></a>
                                <a href="{{ route('admin.trip.incexc', $package->id) }}" class="btn btn-outline-secondary" title="Inc/Exc"><i class="bi bi-check2-square"></i></a>
                                <a href="{{ route('admin.trip.equipment', $package->id) }}" class="btn btn-outline-warning" title="Equipment"><i class="bi bi-backpack"></i></a>
                                <a href="{{ route('admin.package.edit', $package->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(event, 'deleteForm{{ $package->id }}')"><i class="bi bi-trash"></i></button>
                            </div>
                            <form action="{{ route('admin.package.destroy', $package->id) }}" method="POST" id="deleteForm{{ $package->id }}" style="display: none;">@csrf @method('DELETE')</form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No packages found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($packages->hasPages())
        <nav class="d-flex justify-content-end mt-3">{{ $packages->appends($filters ?? [])->links() }}</nav>
    @endif
</div>
