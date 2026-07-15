<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="70">Image</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th width="70">Order</th>
                    <th width="90">Status</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td><img src="{{ $product->thumbnail_url ?? asset('default/noimage.png') }}" width="50" height="50" style="object-fit: cover; border-radius: 4px;"></td>
                        <td>
                            <strong>{{ $product->name }}</strong><br>
                            <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                            @if($product->is_featured)
                                <span class="badge bg-warning text-dark ms-1"><i class="bi bi-star-fill"></i></span>
                            @endif
                        </td>
                        <td><span class="badge bg-info text-capitalize">{{ $product->product_type }}</span></td>
                        <td>{{ $product->brand?->name ?? '-' }}</td>
                        <td>
                            @if($product->is_on_sale)
                                <del class="text-muted small">${{ number_format($product->regular_price, 2) }}</del><br>
                                <strong class="text-success">${{ number_format($product->final_price, 2) }}</strong>
                            @else
                                ${{ number_format($product->regular_price ?? 0, 2) }}
                            @endif
                        </td>
                        <td>
                            @if($product->manage_stock)
                                <span class="badge {{ $product->stock_quantity > $product->low_stock_threshold ? 'bg-success' : ($product->stock_quantity > 0 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $product->stock_quantity }}
                                </span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td><input type="number" value="{{ $product->order_level }}" data-id="{{ $product->id }}" class="form-control form-control-sm order-level-input" style="width: 60px;"></td>
                        <td>
                            <form class="status-form" data-id="{{ $product->id }}">
                                @csrf <input type="hidden" name="status_id" value="{{ $product->id }}">
                                <input type="checkbox" {{ $product->status ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm">
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @if($product->product_type === 'variable')
                                    <a href="{{ route('ecom.product.variants.index', $product->id) }}" class="btn btn-outline-info" title="Variants"><i class="bi bi-diagram-3"></i></a>
                                @endif
                                <a href="{{ route('ecom.product.edit', $product->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(event, 'deleteForm{{ $product->id }}')"><i class="bi bi-trash"></i></button>
                            </div>
                            <form action="{{ route('ecom.product.destroy', $product->id) }}" method="POST" id="deleteForm{{ $product->id }}" style="display: none;">@csrf @method('DELETE')</form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center py-4 text-muted">No products found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
        <nav class="d-flex justify-content-end mt-3">{{ $products->appends($filters ?? [])->links() }}</nav>
    @endif
</div>