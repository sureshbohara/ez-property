@extends('layouts.app')
@section('title', 'Product Variants')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Product Variants" subTitle="For: {{ $product->name }}" :breadcrumbItems="['Dashboard', 'E-Commerce', 'Products', 'Variants']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-diagram-3 me-2"></i> Variants for: {{ $product->name }}</h6>
            <a href="{{ route('ecom.product.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
        <div class="card-body bg-light p-3">
            
           
            <div class="card mb-3">
                <div class="card-header"><h6 class="mb-0">Add New Variant</h6></div>
                <div class="card-body">
                    <form id="variantForm">
                        @csrf
                        <div class="row g-3">
                            @foreach($attributes as $attr)
                                <div class="col-md-3">
                                    <label class="form-label">{{ $attr->name }}</label>
                                    <select name="attributes[{{ $attr->name }}]" class="form-select">
                                        <option value="">Select</option>
                                        @foreach($attr->values ?? [] as $val)
                                            <option value="{{ is_array($val) ? ($val['label'] ?? $val['value'] ?? '') : $val }}">
                                                {{ is_array($val) ? ($val['label'] ?? $val['value'] ?? '') : $val }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                            
                            <x-input-field type="text" name="sku" label="SKU" cols="col-md-3"/>
                            <x-input-field type="number" name="price" label="Price" cols="col-md-2" step="0.01"/>
                            <x-input-field type="number" name="stock_quantity" label="Stock" cols="col-md-2" value="0"/>

                            <div class="col-md-2" style="margin-top: 45px;">
                                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-plus-circle"></i> Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

      
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>Image</th>
                            <th>Attributes</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($variants as $variant)
                            <tr id="variant-row-{{ $variant->id }}">
                                <td>
                                    <img src="{{ $variant->image ? asset('storage/'.$variant->image) : asset('default/noimage.png') }}" 
                                         width="40" height="40" style="object-fit: cover;">
                                </td>
                                <td>
                                    @foreach($variant->attributes ?? [] as $key => $val)
                                        <span class="badge bg-light text-dark border">{{ $key }}: {{ $val }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $variant->sku ?? '-' }}</td>
                                <td>${{ number_format($variant->price ?? 0, 2) }}</td>
                                <td>{{ $variant->stock_quantity }}</td>
                                <td>
                                    <span class="badge {{ $variant->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $variant->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-outline-danger btn-sm" 
                                            onclick="deleteVariant({{ $variant->id }})">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-4 text-muted">No variants yet</td></tr>
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
        $('#variantForm').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Processing...');

            $.ajax({
                type: 'POST',
                url: "{{ route('ecom.product.variants.store', $product->id) }}",
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    toastr.success(res.message);
                    setTimeout(() => location.reload(), 1000);
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html(originalText);
                    console.error('Error:', xhr.responseJSON);
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(k, v) {
                            toastr.error(v[0]);
                        });
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Error creating variant');
                    }
                }
            });
        });
    });
    function deleteVariant(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This variant will be permanently deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: "{{ url('admin/ecom/product/variant') }}/" + id,
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(res) {
                        toastr.success(res.message || 'Variant deleted!');
                        $('#variant-row-' + id).fadeOut(500, function() {
                            $(this).remove();
                        });
                    },
                    error: function(xhr) {
                        console.error('Delete Error:', xhr.responseJSON);
                        toastr.error(xhr.responseJSON?.message || 'Error deleting variant');
                    }
                });
            }
        });
    }
</script>
@endpush