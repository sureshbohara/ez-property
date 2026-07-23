<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Listing;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Checkout Screen मा Booking Confirm गर्न
    public function store(Request $request) {
        $validated = $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'check_in'   => 'required|date',
            'check_out'  => 'required|date|after:check_in',
            'guests'     => 'required|integer|min:1',
            'total_price'=> 'required|numeric',
        ]);

        $booking = Booking::create([
            'user_id'        => $request->user()->id,
            'listing_id'     => $validated['listing_id'],
            'check_in'       => $validated['check_in'],
            'check_out'      => $validated['check_out'],
            'guests'         => $validated['guests'],
            'total_price'    => $validated['total_price'],
            'status'         => 'pending',
            'payment_status' => 'unpaid',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Booking confirmed successfully!',
            'data' => $booking->load('listing.user')
        ], 201);
    }

    // My Trips (Guest) and Reservations (Host/Admin)
    public function myBookings(Request $request) {
        $user = $request->user();
        $query = Booking::query();

        // Guest: related data
        if ($user->role === 'guest') {
            $query->where('user_id', $user->id)
                  ->with(['listing:id,title,slug,image,city,user_id', 'listing.user:id,name,image']);
        } 
        // Host: related data
        elseif ($user->role === 'host') {
            $query->whereHas('listing', fn($q) => $q->where('user_id', $user->id))
                  ->with(['listing:id,title,slug,image,city', 'user:id,name,image']);
        } 
        // Admin: All booking Show
        else {
            $query->with(['listing:id,title,slug,image,city', 'user:id,name,image']);
        }

        $bookings = $query->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $bookings
        ]);
    }

    // Booking Cancel  (Only if status is pending)
    public function cancel(Request $request, $id) {
        $user = $request->user();
        
        $booking = Booking::where('id', $id);
        
        if ($user->role === 'guest') {
            $booking->where('user_id', $user->id);
        }
        $booking = $booking->firstOrFail();
        if ($booking->status !== 'pending') {
            return response()->json([
                'status' => false,
                'message' => "Booking cannot be cancelled because it is already {$booking->status}."
            ], 400);
        }

        $booking->update(['status' => 'cancelled']);
        return response()->json([
            'status' => true,
            'message' => 'Booking cancelled successfully'
        ]);
    }
}