<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;
use App\Http\Resources\ListingResource;

class FavoriteController extends Controller
{
  
    public function index(Request $request) {
        $listings = $request->user()->savedListings()
            ->with(['reviews' => fn($q) => $q->select('listing_id', 'overall_rating')])
            ->latest()->get();

        return response()->json([
            'status' => true,
            'data' => ListingResource::collection($listings)
        ]);
    }

    public function toggle(Request $request) {
        $request->validate([
            'listing_id' => 'required|exists:listings,id'
        ]);
        $user = $request->user();
        $listingId = $request->listing_id;

        if ($user->savedListings()->where('listing_id', $listingId)->exists()) {
            $user->savedListings()->detach($listingId);
            $isSaved = false;
            $message = 'Removed from favorites';
        } else {
            $user->savedListings()->attach($listingId);
            $isSaved = true;
            $message = 'Added to favorites';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'is_saved' => $isSaved
        ]);
    }
    
}