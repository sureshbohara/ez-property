<?php

namespace App\Http\Controllers\Listing;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Booking;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class BookingController extends BaseController
{
    
    public function index(Request $request){
        $filter             = $request->get('filter', 'Total');
        $statusFilter       = $request->get('status', 'all');
        $paymentStatusFilter = $request->get('payment_status', 'all');

        $query = Booking::with(['listing', 'user']);
        // ─── Date Filter ───────────────────────────
        switch ($filter) {
            case 'Today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'This Week':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek(),
                ]);
                break;
            case 'This Month':
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
                break;
            case 'This Year':
                $query->whereYear('created_at', Carbon::now()->year);
                break;
        }

        // ─── Booking Status Filter ─────────────────
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }
        // ─── Payment Status Filter ─────────────────
        if ($paymentStatusFilter !== 'all') {
            $query->where('payment_status', $paymentStatusFilter);
        }
        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);
        // ─── Stats ─────────────────────────────────
        $stats = $this->getStats();
        return view('listings.booking.index', compact(
            'bookings',
            'filter',
            'statusFilter',
            'paymentStatusFilter',
            'stats'
        ));
    }

    private function getStats(): array
    {
        return [
            'total_bookings'    => Booking::count(),
            'total_revenue'     => Booking::sum('total_price'),

            'pending_count'     => Booking::where('status', 'pending')->count(),
            'pending_amount'    => Booking::where('status', 'pending')->sum('total_price'),

            'confirmed_count'   => Booking::where('status', 'confirmed')->count(),
            'confirmed_amount'  => Booking::where('status', 'confirmed')->sum('total_price'),

            'completed_count'   => Booking::where('status', 'completed')->count(),
            'completed_amount'  => Booking::where('status', 'completed')->sum('total_price'),

            'cancelled_count'   => Booking::where('status', 'cancelled')->count(),
            'cancelled_amount'  => Booking::where('status', 'cancelled')->sum('total_price'),
        ];
    }

    public function updateStatus(Request $request, $id){
        $request->validate([
            'status'         => 'required|in:pending,confirmed,cancelled,completed',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);
        $booking = Booking::findOrFail($id);
        $booking->status         = $request->status;
        $booking->payment_status = $request->payment_status;
        $booking->save();
        return redirect()->back()->with('success', 'Booking updated successfully!');
    }

    public function destroy($id){
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return redirect()->back()->with('success', 'Booking deleted successfully!');
    }
}