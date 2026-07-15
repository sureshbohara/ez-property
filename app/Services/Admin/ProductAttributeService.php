<?php

namespace App\Services\Admin;

use App\Models\ProductAttribute;

class ProductAttributeService
{
    public function __construct(protected ProductAttribute $attribute) {}

    public function getAttributes(array $filters = []) {
        return $this->attribute->query()
            ->when(!empty($filters['status']), fn($q) => $q->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN)))
            ->when(!empty($filters['name']), fn($q) => $q->where('name', 'like', '%'.$filters['name'].'%'))
            ->ordered()
            ->paginate(15)
            ->appends($filters);
    }

    public function storeAttribute(array $data) {
        
        if (isset($data['values']) && is_array($data['values'])) {
            $data['values'] = array_values(array_filter($data['values'], fn($v) => !empty(trim($v))));
        } else {
            $data['values'] = []; 
        }
        
        if (!isset($data['status'])) {
            $data['status'] = true;
        }
        
        return $this->attribute->create($data);
    }

    public function updateAttribute(int $id, array $data) {
        $attribute = $this->attribute->findOrFail($id);
        
        if (isset($data['values']) && is_array($data['values'])) {
            $data['values'] = array_values(array_filter($data['values'], fn($v) => !empty(trim($v))));
        }
        
        $attribute->update($data);
        return $attribute->fresh();
    }

    public function deleteAttribute(int $id): bool {
        return $this->attribute->findOrFail($id)->delete();
    }

    public function toggleStatus(int $id): bool {
        $attribute = $this->attribute->findOrFail($id);
        $attribute->status = !$attribute->status;
        $attribute->save();
        return $attribute->status;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool {
        $attribute = $this->attribute->findOrFail($id);
        $attribute->order_level = $orderLevel;
        $attribute->save();
        return true;
    }
}