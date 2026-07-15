<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Values</th>
                    <th width="70">Order</th>
                    <th width="90">Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attributes as $attr)
                    <tr>
                        <td><strong>{{ $attr->name }}</strong><br><small class="text-muted">/{{ $attr->slug }}</small></td>
                        <td><span class="badge bg-info text-capitalize">{{ $attr->type }}</span></td>
                        <td>
                            @if($attr->values)
                                @foreach(array_slice($attr->values, 0, 5) as $val)
                                    <span class="badge bg-light text-dark border me-1">{{ is_array($val) ? ($val['label'] ?? $val['value'] ?? '') : $val }}</span>
                                @endforeach
                                @if(count($attr->values) > 5)
                                    <span class="badge bg-secondary">+{{ count($attr->values) - 5 }} more</span>
                                @endif
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td><input type="number" value="{{ $attr->order_level }}" data-id="{{ $attr->id }}" class="form-control form-control-sm order-level-input" style="width: 60px;"></td>
                        <td>
                            <form class="status-form" data-id="{{ $attr->id }}">
                                @csrf <input type="hidden" name="status_id" value="{{ $attr->id }}">
                                <input type="checkbox" {{ $attr->status ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm">
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('ecom.product-attribute.edit', $attr->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(event, 'deleteForm{{ $attr->id }}')"><i class="bi bi-trash"></i></button>
                            </div>
                            <form action="{{ route('ecom.product-attribute.destroy', $attr->id) }}" method="POST" id="deleteForm{{ $attr->id }}" style="display: none;">@csrf @method('DELETE')</form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No attributes found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($attributes->hasPages())
        <nav class="d-flex justify-content-end mt-3">{{ $attributes->appends($filters ?? [])->links() }}</nav>
    @endif
</div>