<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;

class CheckoutController extends Controller
{


    public function index(Request $request){
        $validated = $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'check_in'   => 'required|date',
            'check_out'  => 'required|date|after:check_in',
            'guests'     => 'required|integer|min:1',
        ]);
        $listing = Listing::findOrFail($validated['listing_id']);
        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);

        //  price calculation
        $nights = $checkIn->diffInDays($checkOut);
        $basePrice = $listing->base_price;
        $cleaningFee = $listing->cleaning_fee ?? 0;
        $serviceFee = $listing->service_fee ?? 0;
        $totalNightsPrice = $nights * $basePrice;
        $grandTotal = $totalNightsPrice + $cleaningFee + $serviceFee;
        return Inertia::render('Checkout', [
            'listing'  => $listing,
            'checkIn'  => $validated['check_in'],
            'checkOut' => $validated['check_out'],
            'guests'   => $validated['guests'],
            'pricing'  => [
                'nights'           => $nights,
                'basePrice'        => $basePrice,
                'totalNightsPrice' => $totalNightsPrice,
                'cleaningFee'      => $cleaningFee,
                'serviceFee'       => $serviceFee,
                'grandTotal'       => $grandTotal,
            ]
        ]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'check_in'   => 'required|date',
            'check_out'  => 'required|date|after:check_in',
            'guests'     => 'required|integer|min:1',
            'total_price'=> 'required|numeric',
        ]);
        Booking::create([
            'user_id'        => Auth::id(),
            'listing_id'     => $validated['listing_id'],
            'check_in'       => $validated['check_in'],
            'check_out'      => $validated['check_out'],
            'guests'         => $validated['guests'],
            'total_price'    => $validated['total_price'],
            'status'         => 'pending',
            'payment_status' => 'unpaid',
        ]);
        return redirect()->route('front.dashboard')->with('success', 'Booking confirmed successfully! Please pay at the property.');
    }
    
}