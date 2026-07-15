<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\OfferRequest;
use App\Services\Admin\OfferService;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Offer;

class OfferController extends BaseController
{
    public function __construct(protected OfferService $service) {
        $this->middleware('can:offer.read')->only(['index']);
        $this->middleware('can:offer.create')->only(['create', 'store']);
        $this->middleware('can:offer.update')->only(['edit', 'update', 'toggleStatus']);
        $this->middleware('can:offer.delete')->only('destroy');
    }

    public function index(Request $request) {
        $filters = $request->only('status', 'name', 'offer_type');
        return view('ecom.offers.index', [
            'offers' => $this->service->getOffers($filters),
            'filters' => $filters,
        ]);
    }

    public function create() {
        $products = Product::active()->orderBy('name')->get();
        $categories = Category::active()->ordered()->get();
        return view('ecom.offers.form', compact('products', 'categories'));
    }

    public function store(OfferRequest $request): JsonResponse {
        $data = $request->validated();
        $offer = $this->service->storeOffer($data);
        return $this->successJson('Offer created!', $offer, 201);
    }

    public function edit(Offer $offer) {
        $products = Product::active()->orderBy('name')->get();
        $categories = Category::active()->ordered()->get();
        return view('ecom.offers.form', compact('offer', 'products', 'categories'));
    }

    public function update(OfferRequest $request, Offer $offer): JsonResponse {
        $data = $request->validated();
        $updated = $this->service->updateOffer($offer->id, $data);
        return $this->successJson('Offer updated!', $updated);
    }

    public function destroy(Offer $offer) {
        $this->service->deleteOffer($offer->id);
        return redirect()->back()->with('success', 'Offer deleted!');
    }

    public function toggleStatus(Request $request): JsonResponse {
        $request->validate(['status_id' => 'required|exists:offers,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }
}