<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="80">Image</th>
                    <th>Title</th>
                    <th>Subtitle</th>
                    <th width="80">Order</th>
                    <th width="100">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>

                        <td>
                            <img src="{{ $service->image_url }}" width="60" height="40" style="object-fit: cover;">
                        </td>

                        <td>
                            <strong>{{ $service->title }}</strong>
                            <br><small class="text-muted">/{{ $service->slug }}</small>
                        </td>

                        <td>{{ Str::limit($service->subtitle, 30) }}</td>

                        <td>
                            <input type="number" name="order_level" value="{{ $service->order_level }}" 
                                   data-id="{{ $service->id }}" class="form-control form-control-sm order-level-input" style="width: 60px;">
                        </td>

                        <td>
                            <form class="status-form" data-id="{{ $service->id }}">
                                @csrf
                                <input type="hidden" name="status_id" value="{{ $service->id }}">
                                <input type="checkbox" {{ $service->status ? 'checked' : '' }} 
                                       data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm">
                            </form>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.service.edit', $service->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(event, 'deleteForm{{ $service->id }}')"><i class="bi bi-trash"></i></button>
                            </div>
                            <form action="{{ route('admin.service.destroy', $service->id) }}" method="POST" id="deleteForm{{ $service->id }}" style="display: none;">@csrf @method('DELETE')</form>
                        </td>
                        
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No services found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($services->hasPages())
        <nav class="d-flex justify-content-end mt-3">{{ $services->appends($filters ?? [])->links() }}</nav>
    @endif
</div>