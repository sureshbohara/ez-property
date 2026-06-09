<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="50">#</th>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permissions as $index => $perm)
                <tr>
                    <td>{{ $permissions->firstItem() + $index }}</td>
                    <td>
                        <strong>{{ $perm->role->display_name ?? $perm->role->name }}</strong>
                        @if($perm->role->name === 'super_admin')
                            <span class="badge bg-warning text-dark ms-1">Protected</span>
                        @endif
                    </td>
                    <td style="max-width: 320px; vertical-align: middle;">
                        @php
                            $perms = is_array($perm->permissions) 
                                ? $perm->permissions 
                                : json_decode($perm->permissions ?? '{}', true);
                        @endphp
                        <div class="d-flex flex-column gap-1">
                            @php $hasPermissions = false; @endphp
                            @foreach($perms as $entity => $actions)
                                @php
                                    $active = array_filter($actions, fn($v) => $v === '1');
                                    if (empty($active)) continue;
                                    $hasPermissions = true;
                                @endphp
                                <div class="d-flex align-items-center flex-wrap gap-1">
                                    <span class="badge bg-dark fw-semibold text-uppercase" style="font-size: 0.7rem; min-width: 70px; text-align: center;">
                                        {{ $entity }}
                                    </span>
                                    <span class="vr mx-1"></span>
                                    @foreach($active as $action => $val)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25" style="font-size: 0.7rem;">
                                            {{ $action }}
                                        </span>
                                    @endforeach
                                </div>
                            @endforeach
                            @if(!$hasPermissions)
                                <span class="text-muted small">No permissions assigned</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.permission.edit', $perm->id) }}" class="btn btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($perm->role->name !== 'super_admin')
                            <button type="button" class="btn btn-outline-danger" title="Delete" onclick="confirmDelete(event, 'deleteForm{{ $perm->id }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                            @endif
                        </div>
                        <form action="{{ route('admin.permission.destroy', $perm->id) }}" method="POST" id="deleteForm{{ $perm->id }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        <i class="bi bi-shield-lock fs-1"></i><br>
                        No permissions configured
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($permissions->hasPages())
    <nav class="d-flex justify-content-end mt-3">
        {{ $permissions->links() }}
    </nav>
    @endif
</div>