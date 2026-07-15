<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Details</th>
                    <th>Validity</th>
                    <th>Uses</th>
                    <th width="90">Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($offers as $offer)
                    <tr>
                        <td><strong>{{ $offer->name }}</strong><br><small class="text-muted">Priority: {{ $offer->priority }}</small></td>
                        <td><span class="badge bg-info text-capitalize">{{ str_replace('_', ' ', $offer->offer_type) }}</span></td>
                        <td>
                            @if($offer->offer_type === 'buy_x_get_y_free')
                                Buy {{ $offer->buy_quantity }} Get {{ $offer->get_quantity }} Free
                            @elseif($offer->offer_type === 'percentage_discount')
                                {{ $offer->discount_value }}% Off
                            @elseif($offer->offer_type === 'flat_discount')
                                ${{ number_format($offer->discount_value, 2) }} Off
                            @elseif($offer->offer_type === 'free_shipping')
                                Free Shipping
                            @endif
                        </td>
                        <td><small>{{ $offer->start_date?->format('M d') ?? '∞' }} - {{ $offer->end_date?->format('M d, Y') ?? '∞' }}</small></td>
                        <td>{{ $offer->used_count }} / {{ $offer->max_uses ?? '∞' }}</td>
                        <td>
                            <form class="status-form" data-id="{{ $offer->id }}">
                                @csrf <input type="hidden" name="status_id" value="{{ $offer->id }}">
                                <input type="checkbox" {{ $offer->status ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm">
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('ecom.offer.edit', $offer->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(event, 'deleteForm{{ $offer->id }}')"><i class="bi bi-trash"></i></button>
                            </div>
                            <form action="{{ route('ecom.offer.destroy', $offer->id) }}" method="POST" id="deleteForm{{ $offer->id }}" style="display: none;">@csrf @method('DELETE')</form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No offers found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($offers->hasPages())
        <nav class="d-flex justify-content-end mt-3">{{ $offers->appends($filters ?? [])->links() }}</nav>
    @endif
</div>