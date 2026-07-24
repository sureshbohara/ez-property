<?php

namespace App\Http\Controllers\Listing;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HostGuestController extends Controller
{


    public function index(Request $request){
        $filters = $request->only(['name', 'role', 'host_status']);
        
        $users = User::query()
            ->when(!empty($filters['name']), fn($q) => $q->where('name', 'like', '%'.$filters['name'].'%')->orWhere('email', 'like', '%'.$filters['name'].'%'))
            ->when(!empty($filters['role']), fn($q) => $q->where('role', $filters['role']))
            ->when(!empty($filters['host_status']), fn($q) => $q->where('host_status', $filters['host_status']))
            ->latest()
            ->paginate(15)
            ->appends($filters);

        return view('listings.host_users.index', compact('users', 'filters'));
    }

    public function approveHost($id){
        $user = User::findOrFail($id);
        if ($user->host_status === 'pending') {
            $user->update([
                'role' => 'host',
                'host_status' => 'approved'
            ]);
            return redirect()->back()->with('success', 'Host approved successfully! User can now list properties.');
        }
        return redirect()->back()->with('error', 'This user is not pending approval.');
    }

    public function rejectHost($id){
        $user = User::findOrFail($id);
        if ($user->host_status === 'pending') {
            $user->update([
                'host_status' => 'rejected',
                'pan_number' => null,
                'citizenship_number' => null,
            ]);
            return redirect()->back()->with('success', 'Host request rejected.');
        }
        return redirect()->back()->with('error', 'This user is not pending approval.');
    }


}