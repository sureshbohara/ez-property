@extends('layouts.app')
@section('title', isset($product) ? 'Edit Product' : 'Create Product')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Products" subTitle="{{ isset($product) ? 'Update' : 'Create' }}" :breadcrumbItems="['Dashboard', 'E-Commerce', 'Products']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0"><i class="bi bi-box-seam me-2"></i> {{ isset($product) ? 'Update' : 'Create' }} Product</h6>
            <a href="{{ route('ecom.product.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="productForm" method="POST" enctype="multipart/form-data" action="{{ isset($product) ? route('ecom.product.update', $product->id) : route('ecom.product.store') }}">
                @csrf
                @if(isset($product)) @method('PUT') @endif

                <div class="row g-3">
          
                   
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                
                                <h5 class="card-title mb-3 border-bottom pb-2">Basic Information</h5>

                         
                                <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                                    <i class="bi bi-lightbulb me-2"></i>
                                    <strong>Understanding Product Types:</strong>
                                    <div class="small mt-2">
                                        <ul class="mb-0 ps-3">
                                            <li><b>Simple Product:</b> A standard product with no variations. <br>
                                                <em class="text-muted">Example: A plain coffee mug, a book, a candle.</em>
                                            </li>
                                            <li><b>Variable Product:</b> A product with multiple options (size, color, etc.). Each variation can have its own price and stock. <br>
                                                <em class="text-muted">Example: A T-shirt available in S/M/L/XL and Red/Blue colors.</em>
                                            </li>
                                            <li><b>Grouped Product:</b> A collection of related simple products displayed together. Customers buy them individually. <br>
                                                <em class="text-muted">Example: A "Furniture Set" grouping a table, chair, and sofa (each sold separately).</em>
                                            </li>
                                            <li><b>Digital / Downloadable:</b> A non-physical product customers download after purchase. No shipping required. <br>
                                                <em class="text-muted">Example: E-books, software, music files, online courses.</em>
                                            </li>
                                        </ul>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <div class="row g-3">

                                    <div class="col-md-12 col-12">
                                        <label class="form-label fw-semibold">Product Type</label>
                                        <select name="product_type" id="productType" class="form-select" required>
                                            <option value="">Select Type</option>
                                            <option value="simple" {{ old('product_type', $product->product_type ?? '') == 'simple' ? 'selected' : '' }}>Simple Product</option>
                                            <option value="variable" {{ old('product_type', $product->product_type ?? '') == 'variable' ? 'selected' : '' }}>Variable Product</option>
                                            <option value="grouped" {{ old('product_type', $product->product_type ?? '') == 'grouped' ? 'selected' : '' }}>Grouped Product</option>
                                            <option value="digital" {{ old('product_type', $product->product_type ?? '') == 'digital' ? 'selected' : '' }}>Digital / Downloadable</option>
                                        </select>
                                        <small class="form-text text-muted">Choose the type that matches your product. Selecting "Grouped" or "Digital" will reveal extra fields below.</small>
                                    </div>

                                    <x-input-field type="text" name="name" label="Product Name" :value="old('name', $product->name ?? '')" cols="col-md-12 col-12" required placeholder="e.g., Classic T-Shirt"/>
                                    
                                    <x-input-field type="textarea" name="description" label="Full Description" :value="old('description', $product->description ?? '')" cols="col-12" rows="6" editor="true"/>
                                </div>

                              
                                <h5 class="card-title mb-3 mt-4 pt-3 border-top border-bottom pb-2">Pricing & Inventory</h5>

                            
                                <div class="alert alert-light border alert-dismissible fade show mb-3" role="alert">
                                    <i class="bi bi-cash-coin me-2 text-success"></i>
                                    <strong>Pricing & Inventory Guide:</strong>
                                    <div class="small mt-2">
                                        <strong>💰 Pricing:</strong>
                                        <ul class="mb-1 ps-3">
                                            <li><b>Regular Price:</b> The standard selling price of the product.</li>
                                            <li><b>Sale Price:</b> A discounted price. Leave blank if not on sale. <br>
                                                <em class="text-muted">Example: Regular $50, Sale $40 → Customer sees "Was $50, Now $40".</em>
                                            </li>
                                            <li><b>Sale Start / End:</b> Schedule when the sale is active. Leave blank for a permanent sale.</li>
                                        </ul>
                                        <strong>📦 Inventory:</strong>
                                        <ul class="mb-0 ps-3">
                                            <li><b>Manage Stock:</b> Turn ON to track quantity automatically. When a customer buys, stock decreases.</li>
                                            <li><b>Stock Qty:</b> Current number of items available.</li>
                                            <li><b>Low Stock Alert:</b> You'll get notified when stock falls below this number. <br>
                                                <em class="text-muted">Example: Set to 5 → Alert triggers when only 5 or fewer items remain.</em>
                                            </li>
                                            <li><b>Stock Status:</b> Manual override — use "On Backorder" to allow sales even when out of stock.</li>
                                        </ul>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <div class="row g-3">
                                    <x-input-field type="number" name="regular_price" label="Regular Price" :value="old('regular_price', $product->regular_price ?? '')" cols="col-md-6" step="0.01"/>
                                    <x-input-field type="number" name="sale_price" label="Sale Price" :value="old('sale_price', $product->sale_price ?? '')" cols="col-md-6" step="0.01"/>
                                    <x-input-field type="date" name="sale_price_start" label="Sale Start" :value="old('sale_price_start', isset($product) && $product->sale_price_start ? $product->sale_price_start->format('Y-m-d') : '')" cols="col-md-6"/>
                                    <x-input-field type="date" name="sale_price_end" label="Sale End" :value="old('sale_price_end', isset($product) && $product->sale_price_end ? $product->sale_price_end->format('Y-m-d') : '')" cols="col-md-6"/>

                                    <div class="col-12 mt-3 pt-3 border-top">
                                        <h6 class="mb-3">Inventory</h6>
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="manage_stock" value="1" id="manageStock" {{ old('manage_stock', $product->manage_stock ?? true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="manageStock">Manage Stock</label>
                                                </div>
                                            </div>
                                            <x-input-field type="number" name="stock_quantity" label="Stock Qty" :value="old('stock_quantity', $product->stock_quantity ?? '0')" cols="col-md-3" min="0"/>
                                            <x-input-field type="number" name="low_stock_threshold" label="Low Stock Alert" :value="old('low_stock_threshold', $product->low_stock_threshold ?? '5')" cols="col-md-3" min="0"/>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">Stock Status</label>
                                                <select name="stock_status" class="form-select">
                                                    <option value="in_stock" {{ old('stock_status', $product->stock_status ?? 'in_stock') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                                    <option value="out_of_stock" {{ old('stock_status', $product->stock_status ?? '') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                                    <option value="on_backorder" {{ old('stock_status', $product->stock_status ?? '') == 'on_backorder' ? 'selected' : '' }}>On Backorder</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               
                                <div id="groupedSection" style="{{ old('product_type', $product->product_type ?? '') === 'grouped' ? '' : 'display:none;' }}" class="mt-4 pt-3 border-top">
                                    <h5 class="card-title mb-3 border-bottom pb-2">Grouped Products</h5>
                                    <div class="alert alert-warning small mb-3">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        <strong>Note:</strong> Select the simple products that belong to this group. The price of a grouped product is calculated from its children.
                                    </div>
                                    <div class="bundleDisplay">
                                        @if(isset($product) && $product->bundleItems)
                                            @foreach($product->bundleItems as $index => $bundle)
                                                <div class="row mb-2 bundleItem">
                                                    <div class="col-6">
                                                        <select name="bundle_products[{{ $index }}][product_id]" class="form-select">
                                                            <option value="">Select Product</option>
                                                            @foreach($allProducts as $p)
                                                                <option value="{{ $p->id }}" {{ $bundle->child_product_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-4"><input type="number" name="bundle_products[{{ $index }}][quantity]" class="form-control" value="{{ $bundle->quantity }}" min="1"></div>
                                                    <div class="col-2"><button type="button" class="btn btn-danger btn-sm removeBundle"><i class="bi bi-trash"></i></button></div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-custom btn-sm addBundle"><i class="bi bi-plus-circle"></i> Add Product</button>
                                </div>

                              
                                <div id="digitalSection" style="{{ old('product_type', $product->product_type ?? '') === 'digital' ? '' : 'display:none;' }}" class="mt-4 pt-3 border-top">
                                    <h5 class="card-title mb-3 border-bottom pb-2">Digital Product</h5>
                                    <div class="alert alert-warning small mb-3">
                                        <i class="bi bi-cloud-download me-1"></i>
                                        <strong>Digital Products:</strong> Upload the file customers will download. Set a download limit (e.g., 3 downloads) and expiry (e.g., 30 days) to control access.
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Downloadable File</label>
                                            <input type="file" name="downloadable_file" class="form-control">
                                            @if(isset($product) && $product->downloadable_file)
                                                <small class="text-muted">Current: {{ $product->downloadable_file }}</small>
                                            @endif
                                        </div>
                                        <x-input-field type="number" name="download_limit" label="Download Limit" :value="old('download_limit', $product->download_limit ?? '')" cols="col-md-6"/>
                                        <x-input-field type="number" name="download_expiry_days" label="Expiry (Days)" :value="old('download_expiry_days', $product->download_expiry_days ?? '')" cols="col-md-6"/>
                                    </div>
                                </div>

                               
                                <h5 class="card-title mb-3 mt-4 pt-3 border-top border-bottom pb-2">
                                    <i class="bi bi-question-circle me-2"></i>Frequently Asked Questions
                                </h5>
                                <div class="faqsDisplay">
                                    @if(isset($product) && !empty($product->faqs))
                                        @foreach($product->faqs as $index => $faq)
                                            <div class="card mb-2 faqItem">
                                                <div class="card-body p-2">
                                                    <div class="row">
                                                        <div class="col-11">
                                                            <input type="text" name="faqs[{{ $index }}][question]" class="form-control mb-2" placeholder="Question" value="{{ $faq['question'] ?? '' }}">
                                                            <textarea name="faqs[{{ $index }}][answer]" class="form-control" rows="2" placeholder="Answer">{{ $faq['answer'] ?? '' }}</textarea>
                                                        </div>
                                                        <div class="col-1 d-flex align-items-start">
                                                            <button type="button" class="btn btn-danger btn-sm removeFaq"><i class="bi bi-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-custom btn-sm addFaq"><i class="bi bi-plus-circle"></i> Add FAQ</button>

                                {{-- SEO --}}
                                <h5 class="card-title mb-3 mt-4 pt-3 border-top border-bottom pb-2">SEO Settings</h5>
                                <div class="row g-3">
                                    <x-input-field type="text" name="meta_title" label="Meta Title" :value="old('meta_title', $product->meta_title ?? '')" cols="col-12"/>
                                    <x-input-field type="textarea" name="meta_description" label="Meta Description" :value="old('meta_description', $product->meta_description ?? '')" cols="col-12" rows="2"/>
                                </div>

                            </div>
                        </div>
                    </div>

                 
                    <div class="col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                
                                <h5 class="card-title mb-3 border-bottom pb-2">Settings</h5>

                             
                                <div class="alert alert-light border alert-dismissible fade show mb-3" role="alert">
                                    <i class="bi bi-stars me-2 text-warning"></i>
                                    <strong>Product Flags Explained:</strong>
                                    <div class="small mt-2">
                                        <ul class="mb-0 ps-3">
                                            <li><b>Featured Product:</b> Highlights this product on the homepage, featured sections, or special banners. <br>
                                                <em class="text-muted">Example: Mark "Summer Collection T-Shirt" as featured to show it prominently.</em>
                                            </li>
                                            <li><b>Virtual Product:</b> For products that need NO shipping (services, memberships, gift cards). Shipping fields will be hidden at checkout. <br>
                                                <em class="text-muted">Example: Online consultation, digital membership, gift voucher.</em>
                                            </li>
                                            <li><b>Active:</b> Toggle to publish or hide the product from the store.</li>
                                        </ul>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <div class="row g-3">

                                    <x-input-field type="text" name="sku" label="SKU" :value="old('sku', $product->sku ?? '')" cols="col-md-12" placeholder="e.g., TSH-001"/>
                                    <x-input-field type="text" name="barcode" label="Barcode" :value="old('barcode', $product->barcode ?? '')" cols="col-md-12" placeholder="Optional"/>

                                    <x-input-field type="textarea" name="short_description" label="Short Description" :value="old('short_description', $product->short_description ?? '')" cols="col-12"/>
                                    
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Brand</label>
                                        <select name="brand_id" class="form-select">
                                            <option value="">Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Category</label>
                                        <select name="category_id" class="form-select">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @foreach($category->children as $subCat)
                                                    <option value="{{ $subCat->id }}" {{ old('category_id', $product->category_id ?? '') == $subCat->id ? 'selected' : '' }}>&nbsp;&nbsp;– {{ $subCat->name }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>

                                    <x-input-field type="number" name="order_level" label="Display Order" :value="old('order_level', $product->order_level ?? '0')" cols="col-12" min="0"/>
                                    
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="isFeatured">
                                                <strong>Featured Product</strong>
                                                <small class="d-block text-muted">Show on homepage & featured sections</small>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_virtual" value="1" id="isVirtual" {{ old('is_virtual', $product->is_virtual ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="isVirtual">
                                                <strong>Virtual Product</strong>
                                                <small class="d-block text-muted">No shipping required (services, memberships)</small>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ old('status', $product->status ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status">
                                                <strong>Active</strong>
                                                <small class="d-block text-muted">Visible to customers in the store</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                
                                <h5 class="card-title mb-3 mt-4 pt-3 border-top border-bottom pb-2">Media</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Thumbnail</label>
                                        <input type="file" name="thumbnail" class="form-control" accept="image/*" onchange="previewImage(this, 'thumbPreview')">
                                        <div class="text-center mt-2">
                                            <img src="{{ isset($product) && $product->thumbnail_url ? $product->thumbnail_url : asset('default/noimage.png') }}" class="img-fluid border" id="thumbPreview" style="max-height: 120px; object-fit: cover;">
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Gallery</label>
                                        <input type="file" name="gallery[]" class="form-control" multiple accept="image/*">
                                        @if(isset($product) && !empty($product->gallery))
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                @foreach($product->gallery as $img)
                                                    <div class="gallery-image" style="position:relative;">
                                                        <img src="{{ asset('images/'.$img) }}" width="60" height="60" style="object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                                                        <button type="button" class="btn btn-danger btn-sm delete-gallery-image" data-image="{{ $img }}" style="position:absolute; top:-5px; right:-5px; padding: 0 4px; font-size: 10px;"><i class="bi bi-trash"></i></button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row g-3 mt-2">
                                    <x-input-field type="url" name="video_url" label="Video URL (YouTube/Vimeo)" :value="old('video_url', $product->video_url ?? '')" cols="col-12" placeholder="https://www.youtube.com/watch?v=..."/>
                                    @if(isset($product) && $product->video_url)
                                        <div class="col-12">
                                            <div class="ratio ratio-16x9" style="max-width: 500px;">
                                                <iframe src="{{ $product->video_url }}" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="pt-3">
                                    <button type="submit" class="btn btn-primary w-100 py-2">
                                        <i class="bi bi-save me-2"></i> {{ isset($product) ? 'Update' : 'Create' }} Product
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Product Type Toggle
        $('#productType').on('change', function() {
            const type = $(this).val();
            $('#groupedSection').toggle(type === 'grouped');
            $('#digitalSection').toggle(type === 'digital');
        });

        // Bundle Products
        let bundleIndex = {{ isset($product) ? $product->bundleItems->count() : 0 }};
        $('.addBundle').click(() => {
            $('.bundleDisplay').append(`<div class="row mb-2 bundleItem">
                <div class="col-6"><select name="bundle_products[${bundleIndex}][product_id]" class="form-select">
                    <option value="">Select Product</option>
                    @foreach($allProducts as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
                </select></div>
                <div class="col-4"><input type="number" name="bundle_products[${bundleIndex}][quantity]" class="form-control" value="1" min="1"></div>
                <div class="col-2"><button type="button" class="btn btn-danger btn-sm removeBundle"><i class="bi bi-trash"></i></button></div>
            </div>`);
            bundleIndex++;
        });
        $(document).on('click', '.removeBundle', function() { $(this).closest('.bundleItem').remove(); });

        // FAQs
        $('.addFaq').click(() => {
            let idx = Date.now();
            $('.faqsDisplay').append(`<div class="card mb-2 faqItem">
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-11">
                            <input type="text" name="faqs[${idx}][question]" class="form-control mb-2" placeholder="Question">
                            <textarea name="faqs[${idx}][answer]" class="form-control" rows="2" placeholder="Answer"></textarea>
                        </div>
                        <div class="col-1 d-flex align-items-start">
                            <button type="button" class="btn btn-danger btn-sm removeFaq"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>`);
        });
        $(document).on('click', '.removeFaq', function() { $(this).closest('.faqItem').remove(); });

        // Gallery Delete
        $(document).on('click', '.delete-gallery-image', function() {
            if (!confirm('Delete this image?')) return;
            var btn = this;
            $.ajax({
                type: 'POST', url: "{{ route('ecom.product.delete.gallery') }}",
                data: { image: $(this).data('image'), id: {{ isset($product) ? $product->id : 0 }}, _token: "{{ csrf_token() }}" },
                success: (res) => { if(res.status===200){ toastr.success(res.msg); $(btn).closest('.gallery-image').remove(); } else toastr.error(res.msg); }
            });
        });

        // Form Submit
        $('#productForm').on('submit', function(e) {
            e.preventDefault();
            $('.text-danger').remove(); $('.is-invalid').removeClass('is-invalid');
            const formData = new FormData(this);
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Processing...');

            $.ajax({
                type: 'POST', url: $(this).attr('action'), data: formData, contentType: false, processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: (res) => { toastr.success(res.message); setTimeout(() => window.location.href = '{{ route("ecom.product.index") }}', 1000); },
                error: (xhr) => {
                    submitBtn.prop('disabled', false).html(originalText);
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, (field, errors) => {
                            $('[name="' + field + '"]').first().addClass('is-invalid').after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
                        });
                        toastr.error('Please fix the errors');
                    } else toastr.error('Something went wrong');
                }
            });
        });
    });
</script>
@endpush