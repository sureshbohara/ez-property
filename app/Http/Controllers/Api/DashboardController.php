<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Booking;
use App\Models\ListingReview;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function stats(Request $request) {
        $user = $request->user();
        
        // Guest Dashboard
        if ($user->role === 'guest') {
            $bookings = Booking::where('user_id', $user->id)->with('listing:id,title,slug,image')->get();
            $stats = [
                'total_trips' => $bookings->count(),
                'upcoming_trips' => $bookings->where('status', 'confirmed')->where('check_in', '>=', now())->count(),
            ];
            return response()->json([
                'status' => true,
                'data' => [
                    'role' => 'guest',
                    'stats' => $stats,
                    'recent_bookings' => $bookings->take(5)
                ]
            ]);
        }

        // Host Dashboard
        if ($user->role === 'host') {
            $listings = Listing::where('user_id', $user->id)->get();
            $bookings = Booking::whereHas('listing', fn($q) => $q->where('user_id', $user->id))
                        ->with(['listing:id,title,slug', 'user:id,name,image'])->get();
            $reviews = ListingReview::whereHas('listing', fn($q) => $q->where('user_id', $user->id))->get();
            
            $totalEarnings = Booking::whereHas('listing', fn($q) => $q->where('user_id', $user->id))
                ->where('payment_status', 'paid')->sum('total_price');
            
            $stats = [
                'total_properties' => $listings->count(),
                'total_bookings' => $bookings->count(),
                'total_earnings' => (float) $totalEarnings,
                'avg_rating' => round($reviews->avg('overall_rating') ?? 0, 1),
            ];

            return response()->json([
                'status' => true,
                'data' => [
                    'role' => 'host',
                    'stats' => $stats,
                    'my_listings' => $listings, 
                    'recent_bookings' => $bookings->take(5)
                ]
            ]);
        }

        // Admin Dashboard 
        $stats = [
            'total_properties' => Listing::count(),
            'total_bookings' => Booking::count(),
            'total_earnings' => (float) Booking::where('payment_status', 'paid')->sum('total_price'),
            'total_users' => User::count(),
            'avg_rating' => round(ListingReview::avg('overall_rating') ?? 0, 1),
        ];

        $recent_bookings = Booking::with(['listing:id,title,slug', 'user:id,name,image'])->latest()->take(5)->get();

        return response()->json([
            'status' => true,
            'data' => [
                'role' => 'admin',
                'stats' => $stats,
                'recent_bookings' => $recent_bookings
            ]
        ]);
    }
}