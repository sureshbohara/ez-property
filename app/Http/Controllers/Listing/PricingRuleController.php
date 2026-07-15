<?php

namespace App\Http\Controllers\Listing;

use App\Http\Controllers\Admin\BaseController;
use App\Models\PricingRule;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PricingRuleController extends BaseController {

    public function index() {
        $rules = PricingRule::with('listing')->orderBy('start_date', 'desc')->paginate(15);
        $listings = Listing::orderBy('title')->get();
        return view('listings.pricing_rules.index', compact('rules', 'listings'));
    }

    public function store(Request $request): JsonResponse {
        $validated = $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price_per_night' => 'required|numeric|min:0',
            'minimum_nights' => 'nullable|integer|min:1',
        ]);

        PricingRule::create($validated);
        return response()->json(['status' => 200, 'msg' => 'Pricing rule added successfully!']);
    }

    public function destroy($id): JsonResponse {
        $rule = PricingRule::findOrFail($id);
        $rule->delete();
        return response()->json(['status' => 200, 'msg' => 'Pricing rule deleted!']);
    }
}