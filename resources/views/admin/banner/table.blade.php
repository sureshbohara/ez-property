<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="120">Image</th>
                    <th>Title</th>
                    <th>Subtitle</th>
                    <th width="100">Order</th>
                    <th width="100">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $banner)
                <tr>

                    <td>
                        <img src="{{ $banner->image_url }}" width="80" height="50" style="object-fit: cover;">
                    </td>

                    <td>{{ $banner->title }}</td>

                    <td>{{ Str::limit($banner->subtitle, 30) }}</td>

                    <td>
                        <input type="number" name="order_level"
                        value="{{ $banner->order_level }}"
                        data-id="{{ $banner->id }}"
                        data-original="{{ $banner->order_level }}"
                        class="form-control form-control-sm order-level-input"
                        style="width: 70px;">
                    </td>

                    <td>
                        <form class="status-form" data-id="{{ $banner->id }}">
                            @csrf
                            <input type="hidden" name="status_id" value="{{ $banner->id }}">
                            <input type="checkbox" {{ $banner->status ? 'checked' : '' }}
                            data-toggle="toggle"
                            data-onstyle="success"
                            data-offstyle="danger"
                            data-size="sm"
                            data-width="50">
                        </form>
                    </td>
                    
                    <td>
                        <div class="btn-group btn-group-sm">

                            <a href="{{ route('admin.banner.edit', $banner->id) }}" class="btn btn-primary text-light">
                                <i class="bi bi-pencil"></i>
                            </a>
                            
                            <button type="button" class="btn btn-danger" onclick="confirmDelete(event, 'deleteForm{{ $banner->id }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <form action="{{ route('admin.banner.destroy', $banner->id) }}" method="POST" id="deleteForm{{ $banner->id }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No banners found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($banners->hasPages())
    <nav class="d-flex justify-content-end mt-3">
        {{ $banners->appends(request()->except('page'))->links() }}
    </nav>
    @endif
</div>