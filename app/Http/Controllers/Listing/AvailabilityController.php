<?php

namespace App\Http\Controllers\Listing;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Availability;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class AvailabilityController extends BaseController {

    public function index() {
        $availabilities = Availability::with('listing')
            ->orderBy('listing_id')
            ->orderBy('date', 'asc')
            ->paginate(20);
        $listings = Listing::orderBy('title')->get();
        return view('listings.availabilities.index', compact('availabilities', 'listings'));
    }


    public function store(Request $request): JsonResponse {
        $validated = $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:available,booked,blocked',
            'custom_price' => 'nullable|numeric|min:0',
        ]);
        $start = Carbon::parse($validated['start_date']);
        $end = Carbon::parse($validated['end_date']);
        $createdCount = 0;
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            Availability::updateOrCreate(
                [
                    'listing_id' => $validated['listing_id'],
                    'date' => $date->format('Y-m-d')
                ],
                [
                    'status' => $validated['status'],
                    'custom_price' => $validated['custom_price'] ?? null,
                ]
            );
            $createdCount++;
        }
        return response()->json(['status' => 200, 'msg' => "Availability updated for {$createdCount} date(s)!"]);
    }

    public function toggleStatus(Request $request): JsonResponse {
        $request->validate(['id' => 'required|exists:availabilities,id', 'status' => 'required|in:available,booked,blocked']);
        $avail = Availability::findOrFail($request->id);
        $avail->status = $request->status;
        $avail->save();
        return response()->json(['status' => 200, 'msg' => 'Status updated!']);
    }

    public function destroy($id): JsonResponse {
        $avail = Availability::findOrFail($id);
        $avail->delete();
        return response()->json(['status' => 200, 'msg' => 'Availability record deleted!']);
    }
    
}