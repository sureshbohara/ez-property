<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Min Order</th>
                    <th>Validity</th>
                    <th>Uses</th>
                    <th width="90">Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                    <tr>
                        <td><strong class="text-primary">{{ $coupon->code }}</strong></td>
                        <td><span class="badge bg-info text-capitalize">{{ $coupon->discount_type }}</span></td>
                        <td>
                            @if($coupon->discount_type === 'percentage')
                                {{ $coupon->discount_value }}%
                            @else
                                ${{ number_format($coupon->discount_value, 2) }}
                            @endif
                        </td>
                        <td>${{ number_format($coupon->min_order_amount ?? 0, 2) }}</td>
                        <td><small>{{ $coupon->start_date?->format('M d') ?? '∞' }} - {{ $coupon->end_date?->format('M d, Y') ?? '∞' }}</small></td>
                        <td>{{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }}</td>
                        <td>
                            <form class="status-form" data-id="{{ $coupon->id }}">
                                @csrf <input type="hidden" name="status_id" value="{{ $coupon->id }}">
                                <input type="checkbox" {{ $coupon->status ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm">
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('ecom.coupon.edit', $coupon->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(event, 'deleteForm{{ $coupon->id }}')"><i class="bi bi-trash"></i></button>
                            </div>
                            <form action="{{ route('ecom.coupon.destroy', $coupon->id) }}" method="POST" id="deleteForm{{ $coupon->id }}" style="display: none;">@csrf @method('DELETE')</form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted">No coupons found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($coupons->hasPages())
        <nav class="d-flex justify-content-end mt-3">{{ $coupons->appends($filters ?? [])->links() }}</nav>
    @endif
</div>