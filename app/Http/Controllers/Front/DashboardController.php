<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Listing;
use App\Models\ListingReview;
use App\Models\Booking;
use App\Models\Message;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isHost = $user->role === 'host';

        // Fetch recent messages 
        $messages = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->take(10)
            ->get();

        if ($isHost) {
            // --- HOST DATA ---
            $listings = Listing::where('user_id', $user->id)->get();
            
            $bookings = Booking::whereHas('listing', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->with(['listing', 'user'])
                ->latest()
                ->get();

            $reviews = ListingReview::whereHas('listing', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->with(['user', 'listing'])
                ->latest()
                ->get();

            // Earnings Chart Data (Last 30 Days)
            $earningsData = [];
            $totalEarnings = 0;
            
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $dayLabel = Carbon::now()->subDays($i)->format('M d');
                
                $dailyEarning = Booking::whereHas('listing', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    })
                    ->where('payment_status', 'paid') 
                    ->whereDate('created_at', $date)
                    ->sum('total_price'); 

                $earningsData[] = ['date' => $dayLabel, 'earning' => (float)$dailyEarning];
            }

            $totalEarnings = Booking::whereHas('listing', fn($q) => $q->where('user_id', $user->id))
                ->where('payment_status', 'paid')
                ->sum('total_price');

            $stats = [
                'total_properties' => $listings->count(),
                'total_bookings' => $bookings->count(),
                'total_earnings' => (float)$totalEarnings,
                'avg_rating' => round($reviews->avg('overall_rating') ?? 0, 1),
            ];

            return Inertia::render('Dashboard', [
                'auth' => $user, 'role' => 'host', 'stats' => $stats,
                'listings' => $listings, 'bookings' => $bookings,
                'reviews' => $reviews, 'earningsData' => $earningsData, 'messages' => $messages,
            ]);

        } else {
            // --- GUEST DATA ---
            $bookings = Booking::where('user_id', $user->id)
                ->with(['listing.host', 'listing'])
                ->latest()
                ->get();

            $reviews = ListingReview::where('user_id', $user->id)
                ->with('listing')
                ->latest()
                ->get();

            $upcomingTrips = collect($bookings)->where('status', 'confirmed')->where('check_in', '>=', now())->count();

            $stats = [
                'total_trips' => $bookings->count(),
                'upcoming_trips' => $upcomingTrips,
            ];

            return Inertia::render('Dashboard', [
                'auth' => $user, 'role' => 'guest', 'stats' => $stats,
                'bookings' => $bookings, 'reviews' => $reviews, 'messages' => $messages,
            ]);
        }
    }
}