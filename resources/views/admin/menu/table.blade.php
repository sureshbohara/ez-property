<div class="table-responsive">
    <table class="table table-hover table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>Menu Name</th>
                <th>Slug</th>
                <th>Location</th>
                <th>Items</th>
                <th width="100">Order</th>
                <th width="100">Status</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menus as $menu)
                <tr>
                    <td><strong>{{ $menu->name }}</strong></td>
                    <td><span class="badge bg-secondary">{{ $menu->slug }}</span></td>
                    <td>
                        @if($menu->location)
                            <span class="badge bg-info">{{ \App\Models\Menu::LOCATIONS[$menu->location] ?? $menu->location }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $menu->items->count() }}</td>
                    <td>
                        <input type="number" name="order_level" 
                               value="{{ $menu->order_level }}" 
                               data-id="{{ $menu->id }}" 
                               data-original="{{ $menu->order_level }}" 
                               class="form-control form-control-sm order-level-input" 
                               style="width: 70px;">
                    </td>
                    <td>
                        <form class="status-form" data-id="{{ $menu->id }}">
                            @csrf
                            <input type="hidden" name="status_id" value="{{ $menu->id }}">
                            <input type="checkbox" {{ $menu->status ? 'checked' : '' }} 
                                   data-toggle="toggle" 
                                   data-onstyle="success" 
                                   data-offstyle="danger" 
                                   data-size="sm">
                        </form>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-primary text-white">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-danger" 
                                    onclick="if(confirm('Delete this menu?')) document.getElementById('deleteForm{{ $menu->id }}').submit()">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <form action="{{ route('admin.menu.destroy', $menu->id) }}" 
                              method="POST" 
                              id="deleteForm{{ $menu->id }}" 
                              style="display: none;">
                            @csrf 
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">No menus found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($menus->hasPages())
    <nav class="d-flex justify-content-end mt-3">
        {{ $menus->appends($filters ?? [])->links() }}
    </nav>
@endif