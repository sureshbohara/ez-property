<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Listing;
use App\Models\ListingReview;
use App\Models\Booking;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index(){
        $user = Auth::user();
        $userId = $user->id;
        $isHost = $user->role === 'host';

        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender:id,name,image', 'receiver:id,name,image', 'listing:id,title,slug'])
            ->latest()
            ->get();

        $conversations = $messages->groupBy(function ($msg) use ($userId) {
            return $msg->sender_id === $userId ? $msg->receiver_id : $msg->sender_id;
        })->mapWithKeys(function ($group) use ($userId) {
            $latestMessage = $group->first();
            $otherUser = $latestMessage->sender_id === $userId ? $latestMessage->receiver : $latestMessage->sender;
            $unreadCount = $group->where('receiver_id', $userId)->where('is_read', false)->count();

            return [
                $otherUser->id => [
                    'user' => [
                        'id' => $otherUser->id,
                        'name' => $otherUser->name,
                        'image_url' => $otherUser->image_url,
                    ],
                    'listing' => $latestMessage->listing ? [
                        'id' => $latestMessage->listing->id,
                        'title' => $latestMessage->listing->title,
                        'slug' => $latestMessage->listing->slug,
                    ] : null,
                    'latest_message' => $latestMessage->message,
                    'created_at' => $latestMessage->created_at,
                    'unread_count' => $unreadCount,
                ]
            ];
        });
        
        $bookingPartners = collect();
        
        if ($isHost) {
            $bookings = Booking::whereHas('listing', fn($q) => $q->where('user_id', $userId))
                ->with(['user:id,name,image', 'listing:id,title,slug'])
                ->get();
                
            foreach ($bookings as $booking) {
                if ($booking->user && !$conversations->has($booking->user->id)) {
                    $bookingPartners->put($booking->user->id, [
                        'user' => [
                            'id' => $booking->user->id,
                            'name' => $booking->user->name,
                            'image_url' => $booking->user->image_url,
                        ],
                        'listing' => $booking->listing ? [
                            'id' => $booking->listing->id,
                            'title' => $booking->listing->title,
                            'slug' => $booking->listing->slug,
                        ] : null,
                        'latest_message' => 'Start a conversation about this booking',
                        'created_at' => $booking->created_at,
                        'unread_count' => 0,
                    ]);
                }
            }
        } else {
            // FIX: Added 'user_id' to the listing select clause so nested 'listing.user' can load
            $bookings = Booking::where('user_id', $userId)
                ->with(['listing.user:id,name,image', 'listing:id,title,slug,user_id'])
                ->get();
                
            foreach ($bookings as $booking) {
                if ($booking->listing && $booking->listing->user) {
                    $hostId = $booking->listing->user->id;
                    if (!$conversations->has($hostId)) {
                        $bookingPartners->put($hostId, [
                            'user' => [
                                'id' => $hostId,
                                'name' => $booking->listing->user->name,
                                'image_url' => $booking->listing->user->image_url,
                            ],
                            'listing' => $booking->listing ? [
                                'id' => $booking->listing->id,
                                'title' => $booking->listing->title,
                                'slug' => $booking->listing->slug,
                            ] : null,
                            'latest_message' => 'Start a conversation about your booking',
                            'created_at' => $booking->created_at,
                            'unread_count' => 0,
                        ]);
                    }
                }
            }
        }
        
        $allConversations = collect($conversations)->merge($bookingPartners)->sortByDesc('created_at')->values();

        $totalUnreadCount = Message::where('receiver_id', $userId)->where('is_read', false)->count();

        $savedCount = $user->savedListings()->count();
        $savedListings = $user->savedListings()->with(['category', 'reviews'])->latest()->get();

        if ($isHost) {
            $listings = Listing::where('user_id', $userId)->get();
            $bookings = Booking::whereHas('listing', fn($q) => $q->where('user_id', $userId))->with(['listing', 'user'])->latest()->get();
            $reviews = ListingReview::whereHas('listing', fn($q) => $q->where('user_id', $userId))->with(['user', 'listing'])->latest()->get();

            $earningsData = [];
            $totalEarnings = 0;
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $dayLabel = Carbon::now()->subDays($i)->format('M d');
                $dailyEarning = Booking::whereHas('listing', fn($q) => $q->where('user_id', $userId))
                    ->where('payment_status', 'paid')->whereDate('created_at', $date)->sum('total_price'); 
                $earningsData[] = ['date' => $dayLabel, 'earning' => (float)$dailyEarning];
            }
            $totalEarnings = Booking::whereHas('listing', fn($q) => $q->where('user_id', $userId))->where('payment_status', 'paid')->sum('total_price');
            
            $stats = [
                'total_properties' => $listings->count(),
                'total_bookings' => $bookings->count(),
                'total_earnings' => (float)$totalEarnings,
                'avg_rating' => round($reviews->avg('overall_rating') ?? 0, 1),
            ];

            $myListingsSavedByOthers = Listing::where('user_id', $userId)
                ->with(['savedByUsers:id,name,image'])
                ->withCount('savedByUsers')
                ->having('saved_by_users_count', '>', 0)
                ->get();

            return Inertia::render('Dashboard', [
                'role' => 'host', 
                'stats' => $stats,
                'listings' => $listings, 
                'bookings' => $bookings,
                'reviews' => $reviews, 
                'earningsData' => $earningsData, 
                'messages' => $messages,
                'savedListings' => $savedListings,
                'myListingsSavedByOthers' => $myListingsSavedByOthers,
                'savedCount' => $savedCount,
                'conversations' => $allConversations,      
                'totalUnreadCount' => $totalUnreadCount, 
            ]);

        } else {
            $bookings = Booking::where('user_id', $userId)->with(['listing.host', 'listing'])->latest()->get();
            $reviews = ListingReview::where('user_id', $userId)->with('listing')->latest()->get();
            $upcomingTrips = collect($bookings)->where('status', 'confirmed')->where('check_in', '>=', now())->count();

            $stats = [
                'total_trips' => $bookings->count(),
                'upcoming_trips' => $upcomingTrips,
            ];

            return Inertia::render('Dashboard', [
                'role' => 'guest', 
                'stats' => $stats,
                'bookings' => $bookings, 
                'reviews' => $reviews, 
                'messages' => $messages,
                'savedListings' => $savedListings,
                'savedCount' => $savedCount,
                'conversations' => $allConversations,      
                'totalUnreadCount' => $totalUnreadCount,
            ]);
        }
    }

    public function showConversation($userId){
        $currentUserId = Auth::id();
        $messages = Message::where(function ($q) use ($currentUserId, $userId) {
                $q->where('sender_id', $currentUserId)->where('receiver_id', $userId);
            })->orWhere(function ($q) use ($currentUserId, $userId) {
                $q->where('sender_id', $userId)->where('receiver_id', $currentUserId);
            })
            ->with(['sender:id,name,image', 'receiver:id,name,image', 'listing:id,title,slug'])
            ->orderBy('created_at', 'asc')
            ->get();
            
        Message::where('sender_id', $userId)
            ->where('receiver_id', $currentUserId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $otherUser = User::select('id', 'name', 'image')->findOrFail($userId);

        return response()->json([
            'messages' => $messages,
            'otherUser' => [
                'id' => $otherUser->id,
                'name' => $otherUser->name,
                'image_url' => $otherUser->image_url,
            ],
        ]);
    }

    public function storeMessage(Request $request){
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'listing_id' => 'nullable|exists:listings,id',
            'message' => 'required|string|max:1000',
        ]);
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'listing_id' => $request->listing_id,
            'message' => $request->message,
            'is_read' => false,
        ]);
        $message->load(['sender:id,name,image', 'receiver:id,name,image', 'listing:id,title,slug']);
        
        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
}