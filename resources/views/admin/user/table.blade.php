<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="80">Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width="80">Order</th>
                    <th width="100">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                <tr>
                    <td>
                        <img src="{{ $admin->image_url }}" class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                    </td>
                    <td>
                        <strong>{{ $admin->name }}</strong><br>
                        <small class="text-muted">{{ $admin->mobile }}</small>
                    </td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        <span class="badge bg-info">{{ $admin->role?->display_name ?? 'N/A' }}</span>
                    </td>
                    <td>
                        <input type="number" name="order_level"
                        value="{{ $admin->order_level }}"
                        data-id="{{ $admin->id }}"
                        data-original="{{ $admin->order_level }}"
                        class="form-control form-control-sm order-level-input"
                        style="width: 70px;">
                    </td>
                    <td>
                        <form class="status-form" data-id="{{ $admin->id }}">
                            @csrf
                            <input type="hidden" name="status_id" value="{{ $admin->id }}">
                            <input type="checkbox" {{ $admin->status ? 'checked' : '' }}
                            data-toggle="toggle"
                            data-onstyle="success"
                            data-offstyle="danger"
                            data-size="sm"
                            data-width="50">
                        </form>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.user.edit', $admin->id) }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(event, 'deleteForm{{ $admin->id }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <form action="{{ route('admin.user.destroy', $admin->id) }}" method="POST" id="deleteForm{{ $admin->id }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">No admins found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($admins->hasPages())
    <nav class="d-flex justify-content-end mt-3">
        {{ $admins->appends(request()->except('page'))->links() }}
    </nav>
    @endif
</div>