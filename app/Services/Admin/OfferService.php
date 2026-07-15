<?php

namespace App\Services\Admin;

use App\Models\Offer;

class OfferService
{
    public function __construct(protected Offer $offer) {}

    public function getOffers(array $filters = []) {
        return $this->offer->query()
            ->when(!empty($filters['status']), fn($q) => $q->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN)))
            ->when(!empty($filters['name']), fn($q) => $q->where('name', 'like', '%'.$filters['name'].'%'))
            ->when(!empty($filters['offer_type']), fn($q) => $q->where('offer_type', $filters['offer_type']))
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends($filters);
    }

    public function storeOffer(array $data) {
        return $this->offer->create($data);
    }

    public function updateOffer(int $id, array $data) {
        $offer = $this->offer->findOrFail($id);
        $offer->update($data);
        return $offer->fresh();
    }

    public function deleteOffer(int $id): bool {
        return $this->offer->findOrFail($id)->delete();
    }

    public function toggleStatus(int $id): bool {
        $offer = $this->offer->findOrFail($id);
        $offer->status = !$offer->status;
        $offer->save();
        return $offer->status;
    }
}