<?php
namespace App\Services\Admin;

use App\Models\Amenity;
use Illuminate\Support\Facades\DB;

class AmenityService {
    public function __construct(protected Amenity $amenity) {}

    public function getAmenities(array $filters = []) {
        return $this->amenity->query()
            ->when(!empty($filters['status']), fn($q) => $q->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN)))
            ->when(!empty($filters['name']), fn($q) => $q->where('name', 'like', '%'.$filters['name'].'%'))
            ->ordered()
            ->paginate(15)
            ->appends($filters);
    }

    public function storeAmenity(array $data) {
        return $this->amenity->create($data);
    }

    public function updateAmenity(int $id, array $data) {
        $amenity = $this->amenity->findOrFail($id);
        $amenity->update($data);
        return $amenity->fresh();
    }

    public function deleteAmenity(int $id): bool {
        $amenity = $this->amenity->findOrFail($id);
        return $amenity->delete();
    }

    public function toggleStatus(int $id): bool {
        $amenity = $this->amenity->findOrFail($id);
        $amenity->status = !$amenity->status;
        $amenity->save();
        return $amenity->status;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool {
        $amenity = $this->amenity->findOrFail($id);
        $amenity->order_level = $orderLevel;
        $amenity->save();
        return true;
    }
}