<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="100">Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th width="100">Order</th>
                    <th width="100">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teams as $team)
                <tr>
                    <td>
                        <img src="{{ $team->image_url }}" width="50" height="50" style="object-fit: cover; border-radius: 50%;">
                    </td>
                    <td>{{ $team->name }}</td>
                    <td>{{ $team->email }}</td>
                    <td>
                        <input type="number" name="order_level"
                        value="{{ $team->order_level }}"
                        data-id="{{ $team->id }}"
                        data-original="{{ $team->order_level }}"
                        class="form-control form-control-sm order-level-input"
                        style="width: 70px;">
                    </td>
                    <td>
                        <form class="status-form" data-id="{{ $team->id }}">
                            @csrf
                            <input type="hidden" name="status_id" value="{{ $team->id }}">
                            <input type="checkbox" {{ $team->status ? 'checked' : '' }}
                            data-toggle="toggle"
                            data-onstyle="success"
                            data-offstyle="danger"
                            data-size="sm"
                            data-width="50">
                        </form>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.team.edit', $team->id) }}" class="btn btn-primary text-light">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete(event, 'deleteForm{{ $team->id }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <form action="{{ route('admin.team.destroy', $team->id) }}" method="POST" id="deleteForm{{ $team->id }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No team members found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($teams->hasPages())
    <nav class="d-flex justify-content-end mt-3">
        {{ $teams->appends(request()->except('page'))->links() }}
    </nav>
    @endif
</div>