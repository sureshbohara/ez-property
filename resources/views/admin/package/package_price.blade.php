@extends('layouts.app')
@section('title', 'Package Prices')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Package Management" subTitle="Bulk Price Update" :breadcrumbItems="['Dashboard', 'Packages', 'Prices']" />
    
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-currency-dollar me-2"></i> Update Package Prices</h6>
            <a href="{{ route('admin.package.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to Packages</a>
        </div>
        
        <div class="card-body bg-light p-3">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Bulk Price Editor:</strong> Edit prices directly in the table below. Changes are saved automatically when you click the "Update" button for each package.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-success">
                        <tr>
                            <th width="50">#</th>
                            <th>Package Name</th>
                            <th width="150">Previous Price</th>
                            <th width="150">Current Price</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($datas as $index => $package)
                            <tr id="package-row-{{ $package->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $package->name }}</strong>
                                    <br><small class="text-muted">/{{ $package->slug }}</small>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">$</span>
                                        <input type="number" 
                                               step="0.01" 
                                               class="form-control price-previous" 
                                               value="{{ $package->trip_previous_price }}" 
                                               placeholder="0.00">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">$</span>
                                        <input type="number" 
                                               step="0.01" 
                                               class="form-control price-current" 
                                               value="{{ $package->trip_price }}" 
                                               placeholder="0.00">
                                    </div>
                                </td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-primary btn-sm update-price-btn" 
                                            data-id="{{ $package->id }}">
                                        <i class="bi bi-check-circle me-1"></i> Update
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox me-2"></i> No packages found. Create some packages first.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $(document).on('click', '.update-price-btn', function() {
            const btn = $(this);
            const row = btn.closest('tr');
            const packageId = btn.data('id');
            const previousPrice = row.find('.price-previous').val();
            const currentPrice = row.find('.price-current').val();
            
            const originalText = btn.html();
            btn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Saving...');
            
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.package.prices.update') }}",
                data: {
                    id: packageId,
                    trip_previous_price: previousPrice,
                    trip_price: currentPrice,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success('Prices updated successfully!');
                        btn.html('<i class="bi bi-check-circle me-1"></i> Saved!');
                        setTimeout(() => {
                            btn.prop('disabled', false).html(originalText);
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html(originalText);
                    toastr.error('Failed to update prices. Please try again.');
                }
            });
        });
    });
</script>
@endpush