<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool { return auth('admin')->check(); }

    public function rules(): array {
        $productId = $this->route('product')?->id;
        return [
            'name' => 'required|string|max:255',
            'slug' => $productId ? 'nullable|string|unique:products,slug,' . $productId : 'nullable|string|unique:products,slug',
            'sku' => $productId ? 'nullable|string|unique:products,sku,' . $productId : 'nullable|string|unique:products,sku',
            'barcode' => 'nullable|string|max:100',
            'product_type' => 'required|in:simple,variable,grouped,digital',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'category_id' => 'nullable|integer|exists:categories,id',
            
            'regular_price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sale_price_start' => 'nullable|date',
            'sale_price_end' => 'nullable|date|after_or_equal:sale_price_start',
            
            'manage_stock' => 'nullable|boolean',
            'stock_quantity' => 'nullable|integer|min:0',
            'stock_status' => 'nullable|in:in_stock,out_of_stock,on_backorder',
            'low_stock_threshold' => 'nullable|integer|min:0',
            
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:100',
            
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            
            'downloadable_file' => 'nullable|file|max:51200',
            'download_limit' => 'nullable|integer|min:0',
            'download_expiry_days' => 'nullable|integer|min:0',
            
            'is_featured' => 'nullable|boolean',
            'is_virtual' => 'nullable|boolean',
            'order_level' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
            
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            
            'bundle_products' => 'nullable|array',
            'bundle_products.*.product_id' => 'required_with:bundle_products|integer|exists:products,id',
            'bundle_products.*.quantity' => 'required_with:bundle_products|integer|min:1',


            'video_url' => 'nullable|url|max:500',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'nullable|string|max:500',
            'faqs.*.answer' => 'nullable|string',
        ];
    }
}