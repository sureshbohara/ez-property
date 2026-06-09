<div class="col-12">

    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="40">
                        <input type="checkbox" id="selectAll" class="form-check-input">
                    </th>
                    <th>User</th>
                    <th>Login At</th>
                    <th>Logout At</th>
                    <th>IP Address</th>
                    <th>OS / Browser</th>
                    <th>Device</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                <tr>
                
                    <td>
                        <input type="checkbox" class="form-check-input row-checkbox" value="{{ $activity->id }}">
                    </td>

                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($activity->admin?->image)
                                <img src="{{ Storage::url($activity->admin->image) }}" 
                                     class="rounded-circle" width="32" height="32" style="object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" 
                                     style="width:32px; height:32px; font-size:12px;">
                                    {{ substr($activity->admin?->name ?? 'A', 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <div class="fw-bold small">{{ $activity->admin?->name ?? 'Deleted User' }}</div>
                                <small class="text-muted">{{ Str::limit($activity->admin?->email ?? '-', 20) }}</small>
                            </div>
                        </div>
                    </td>

                 
                    <td>
                        <div class="small">
                            <div>{{ $activity->login_at->format('M d, Y') }}</div>
                            <div class="text-muted">{{ $activity->login_at->format('H:i:s') }}</div>
                        </div>
                    </td>

              
                    <td>
                        @if($activity->logout_at)
                            <div class="small">
                                <div>{{ $activity->logout_at->format('M d, Y') }}</div>
                                <div class="text-muted">{{ $activity->logout_at->format('H:i:s') }}</div>
                            </div>
                        @else
                            <span class="badge bg-success-subtle text-success">
                                <i class="bi bi-circle-fill small me-1"></i>Active
                            </span>
                        @endif
                    </td>

          
                    <td>
                        <code class="small">{{ $activity->ip_address }}</code>
                        <br>
                        <a href="https://ipinfo.io/{{ $activity->ip_address }}" target="_blank" 
                           class="small text-decoration-none">
                            <i class="bi bi-box-arrow-up-right"></i> Lookup
                        </a>
                    </td>

                  
                    <td>
                        <div class="small">
                            <span class="badge bg-warning-subtle text-info mb-1">
                                {{ $activity->os ?: 'Unknown' }}
                            </span><br>
                            <span class="badge bg-warning-subtle text-warning">
                                {{ $activity->browser ?: 'Unknown' }}
                            </span>
                        </div>
                    </td>

                 
                    <td>
                        @if($activity->device_type == 'mobile')
                            <span class="badge bg-warning-subtle text-warning-emphasis">
                                <i class="bi bi-phone"></i> Mobile
                            </span>
                        @elseif($activity->device_type == 'tablet')
                            <span class="badge bg-primary-subtle text-primary-emphasis">
                                <i class="bi bi-tablet"></i> Tablet
                            </span>
                        @else
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-display"></i> Desktop
                            </span>
                        @endif
                    </td>

               
                
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        <p class="mb-0">No login activities found</p>
                        <small>Try adjusting your filters</small>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($activities->hasPages())
    <nav class="d-flex justify-content-end mt-3">
        {{ $activities->appends(request()->query())->links() }}
    </nav>
    @endif
</div>