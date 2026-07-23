<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Collection;

class ChatController extends Controller
{


    public function conversations(Request $request){
        $user = $request->user();
        $userId = $user->id;

        // Admin  Can (Host/Guest)  Chat
        if ($user->role === 'admin') {
            $partners = User::where('id', '!=', $userId)->get();
            $allConversations = $partners->map(function($partner) {
                $lastMsg = Message::where(function($q) use ($partner) {
                    $q->where('sender_id', $partner->id)->orWhere('receiver_id', $partner->id);
                })->latest()->first();

                return [
                    'user' => ['id' => $partner->id, 'name' => $partner->name, 'image_url' => $partner->image_url],
                    'latest_message' => $lastMsg ? $lastMsg->message : 'Start a conversation',
                    'created_at' => $lastMsg ? $lastMsg->created_at : now(),
                    'unread_count' => 0,
                ];
            })->sortByDesc('created_at')->values();
            return response()->json(['status' => true, 'data' => ['conversations' => $allConversations, 'total_unread_count' => 0]]);
        }

        // Host and Guest Logic
        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender:id,name,image', 'receiver:id,name,image', 'listing:id,title,slug'])
            ->latest()->get();

        $conversations = $messages->groupBy(function ($msg) use ($userId) {
            return $msg->sender_id === $userId ? $msg->receiver_id : $msg->sender_id;
        })->mapWithKeys(function ($group) use ($userId) {
            $latestMessage = $group->first();
            $otherUser = $latestMessage->sender_id === $userId ? $latestMessage->receiver : $latestMessage->sender;
            $unreadCount = $group->where('receiver_id', $userId)->where('is_read', false)->count();

            return [
                $otherUser->id => [
                    'user' => ['id' => $otherUser->id, 'name' => $otherUser->name, 'image_url' => $otherUser->image_url],
                    'listing' => $latestMessage->listing ? ['id' => $latestMessage->listing->id, 'title' => $latestMessage->listing->title, 'slug' => $latestMessage->listing->slug] : null,
                    'latest_message' => $latestMessage->message,
                    'created_at' => $latestMessage->created_at,
                    'unread_count' => $unreadCount,
                ]
            ];
        });

        $bookingPartners = collect();
        
        if ($user->role === 'host') {
            $bookings = Booking::whereHas('listing', fn($q) => $q->where('user_id', $userId))
                ->with(['user:id,name,image', 'listing:id,title,slug'])->get();
                
            foreach ($bookings as $booking) {
                if ($booking->user && !$conversations->has($booking->user->id)) {
                    $bookingPartners->put($booking->user->id, [
                        'user' => ['id' => $booking->user->id, 'name' => $booking->user->name, 'image_url' => $booking->user->image_url],
                        'latest_message' => 'Start a conversation with the guest',
                        'created_at' => $booking->created_at,
                        'unread_count' => 0,
                    ]);
                }
            }
        } else {
            $bookings = Booking::where('user_id', $userId)
                ->with(['listing.user:id,name,image', 'listing:id,title,slug,user_id'])->get();
                
            foreach ($bookings as $booking) {
                if ($booking->listing && $booking->listing->user) {
                    $hostId = $booking->listing->user->id;
                    if (!$conversations->has($hostId)) {
                        $bookingPartners->put($hostId, [
                            'user' => ['id' => $hostId, 'name' => $booking->listing->user->name, 'image_url' => $booking->listing->user->image_url],
                            'latest_message' => 'Start a conversation with the host',
                            'created_at' => $booking->created_at,
                            'unread_count' => 0,
                        ]);
                    }
                }
            }
        }
        
        $allConversations = collect($conversations)->merge($bookingPartners)->sortByDesc('created_at')->values();
        $totalUnreadCount = Message::where('receiver_id', $userId)->where('is_read', false)->count();

        return response()->json([
            'status' => true,
            'data' => [
                'conversations' => $allConversations,
                'total_unread_count' => $totalUnreadCount
            ]
        ]);
    }

    public function getMessages(Request $request, $userId){
        $currentUserId = $request->user()->id;
        $messages = Message::where(function ($q) use ($currentUserId, $userId) {
                $q->where('sender_id', $currentUserId)->where('receiver_id', $userId);
            })->orWhere(function ($q) use ($currentUserId, $userId) {
                $q->where('sender_id', $userId)->where('receiver_id', $currentUserId);
            })
            ->with(['sender:id,name,image', 'receiver:id,name,image', 'listing:id,title,slug'])
            ->orderBy('created_at', 'asc')->get();
            
        Message::where('sender_id', $userId)->where('receiver_id', $currentUserId)->where('is_read', false)->update(['is_read' => true]);

        $otherUser = User::select('id', 'name', 'image')->findOrFail($userId);

        return response()->json([
            'status' => true,
            'data' => [
                'messages' => $messages,
                'other_user' => ['id' => $otherUser->id, 'name' => $otherUser->name, 'image_url' => $otherUser->image_url],
            ]
        ]);
    }

    public function sendMessage(Request $request){
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'listing_id' => 'nullable|exists:listings,id',
            'message' => 'required|string|max:1000',
        ]);
        $message = Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $request->receiver_id,
            'listing_id' => $request->listing_id,
            'message' => $request->message,
            'is_read' => false,
        ]);
        $message->load(['sender:id,name,image', 'receiver:id,name,image', 'listing:id,title,slug']);
        return response()->json([
            'status' => true,
            'message' => 'Message sent successfully',
            'data' => $message
        ]);
    }
}