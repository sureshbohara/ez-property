<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="70">Image</th>
                    <th>Display On</th>
                    <th>Title & Location</th>
                    <th>Type</th>
                    <th>Price/Night</th>
                    <th>Capacity</th>
                    <th width="90">Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($listings as $listing)
                <tr>
                    <td><img src="{{ $listing->image_url ?? asset('default/noimage.png') }}" width="60" height="60" style="object-fit: cover; border-radius: 4px;"></td>


                    <td>
                        <select class="form-control listing-type" name="display_on" data-type-id="{{ $listing->id }}">
                            <option value="default" {{ $listing->display_on == 'default' ? 'selected' : '' }}>Default</option>
                            <option value="featured" {{ $listing->display_on == 'featured' ? 'selected' : '' }}>Featured</option>
                            <option value="homestays" {{ $listing->display_on == 'homestays' ? 'selected' : '' }}>Homestays</option>
                            <option value="recommended" {{ $listing->display_on == 'recommended' ? 'selected' : '' }}>Recommended</option>
                            <option value="nearby" {{ $listing->display_on == 'nearby' ? 'selected' : '' }}> Stays Near You</option>
                        </select>
                    </td>

                    <td>
                        <strong>{{ $listing->title }}</strong><br>
                        <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $listing->city }}, {{ $listing->province }}</small>
                    </td>
                    <td><span class="badge bg-info text-capitalize">{{ str_replace('_', ' ', $listing->listing_type) }}</span></td>
                    <td><strong class="text-success">Rs. {{ number_format($listing->base_price, 2) }}</strong></td>
                    <td><small>{{ $listing->guests }} Guests, {{ $listing->bedrooms }} BR</small></td>
                    <td>
                        <form class="status-form" data-id="{{ $listing->id }}">
                            @csrf <input type="hidden" name="status_id" value="{{ $listing->id }}">
                            <input type="checkbox" {{ $listing->status ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm">
                        </form>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('listing.listing.edit', $listing->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(event, 'deleteForm{{ $listing->id }}')"><i class="bi bi-trash"></i></button>
                        </div>
                        <form action="{{ route('listing.listing.destroy', $listing->id) }}" method="POST" id="deleteForm{{ $listing->id }}" style="display: none;">@csrf @method('DELETE')</form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">No listings found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($listings->hasPages())
    <nav class="d-flex justify-content-end mt-3">{{ $listings->appends($filters ?? [])->links() }}</nav>
    @endif
</div>