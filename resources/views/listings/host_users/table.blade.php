<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="60">Image</th>
                    <th>Name / Email</th>
                    <th width="100">Role</th>
                    <th width="120">Host Status</th>
                    <th width="180">Verification Docs</th>
                    <th width="180">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <img src="{{ $user->image_url ?? asset('default/noimage.png') }}" alt="avatar" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                        </td>

                        <td>
                            <strong>{{ $user->name }}</strong><br>
                            <small class="text-muted">{{ $user->email }}</small>
                        </td>

                        <td>
                            @if($user->role == 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @elseif($user->role == 'host')
                                <span class="badge bg-success">Host</span>
                            @else
                                <span class="badge bg-info">Guest</span>
                            @endif
                        </td>

                        <td>
                            @if($user->host_status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($user->host_status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($user->host_status == 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-secondary">None</span>
                            @endif
                        </td>

                        <td>
                            @if($user->pan_number)
                                <small class="d-block text-muted"><strong>PAN:</strong> {{ $user->pan_number }}</small>
                                <small class="d-block text-muted"><strong>ID:</strong> {{ $user->citizenship_number }}</small>
                            @else
                                <small class="text-muted">N/A</small>
                            @endif
                        </td>

                        <td>
                            @if($user->host_status == 'pending')
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('listing.host.approve', $user->id) }}" class="btn btn-outline-success"><i class="bi bi-check-circle"></i> Approve</a>
                                    <a href="{{ route('listing.host.reject', $user->id) }}" class="btn btn-outline-danger"><i class="bi bi-x-circle"></i> Reject</a>
                                </div>
                            @else
                                <span class="text-muted">No actions needed</span>
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No users found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <nav class="d-flex justify-content-end mt-3">{{ $users->appends($filters ?? [])->links() }}</nav>
    @endif
    
</div>