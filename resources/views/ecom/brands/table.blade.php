<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="70">Logo</th>
                    <th>Name</th>
                    <th>Website</th>
                    <th width="70">Order</th>
                    <th width="90">Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                    <tr>
                        <td><img src="{{ $brand->logo_url }}" width="50" height="40" style="object-fit: contain; border-radius: 4px;"></td>
                        <td><strong>{{ $brand->name }}</strong><br><small class="text-muted">/{{ $brand->slug }}</small></td>
                        <td>{{ $brand->website ? Str::limit($brand->website, 30) : 'N/A' }}</td>
                        <td><input type="number" value="{{ $brand->order_level }}" data-id="{{ $brand->id }}" class="form-control form-control-sm order-level-input" style="width: 60px;"></td>
                        <td>
                            <form class="status-form" data-id="{{ $brand->id }}">
                                @csrf <input type="hidden" name="status_id" value="{{ $brand->id }}">
                                <input type="checkbox" {{ $brand->status ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm">
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('ecom.brand.edit', $brand->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(event, 'deleteForm{{ $brand->id }}')"><i class="bi bi-trash"></i></button>
                            </div>
                            <form action="{{ route('ecom.brand.destroy', $brand->id) }}" method="POST" id="deleteForm{{ $brand->id }}" style="display: none;">@csrf @method('DELETE')</form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No brands found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($brands->hasPages())
        <nav class="d-flex justify-content-end mt-3">{{ $brands->appends($filters ?? [])->links() }}</nav>
    @endif
</div>