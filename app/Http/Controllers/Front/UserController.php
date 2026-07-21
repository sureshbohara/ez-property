<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Admin\MediaService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    protected $mediaService;


    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function showLogin() {
        return Inertia::render('Auth/Login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'boolean',
        ]);
        
        if (Auth::attempt(
            ['email' => $request->email, 'password' => $request->password],
            $request->boolean('remember')
        )) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }
        
        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    public function showRegister() {
        return Inertia::render('Auth/Register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'guest',
        ]);
        
        Auth::login($user);
        return redirect('/')->with('success', 'Account created successfully! Welcome, ' . $user->name . '.');
    }


    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logged out successfully!');
    }


    public function showBecomeHost() {
        return Inertia::render('Auth/BecomeHost');
    }


    public function upgradeToHost(Request $request) {
        $user = $request->user();
        if ($user->role === 'guest') {
            $user->role = 'host';
            $user->save();
        }
        return redirect()->route('front.properties.create')->with('success', 'You are now a host! List your first property.');
    }


    public function updateProfile(Request $request){
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gender' => 'nullable|string|max:20',
            'details' => 'nullable|string|max:1000',
        ]);

        $data = $request->only('name', 'email', 'phone', 'address', 'gender', 'details');
        if ($request->hasFile('image')) {
            if ($user->image && !filter_var($user->image, FILTER_VALIDATE_URL)) {
                $this->mediaService->deleteImageVariants($user->image);
            }
            $path = $this->mediaService->uploadImage($request->file('image'));
            $this->mediaService->dispatchImageProcessing($path);
            $data['image'] = $path;
        }
        $user->update($data);

    }


    public function updatePassword(Request $request){
        $user = Auth::user();
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Current password is incorrect.']
            ]);
        }
        $user->update(['password' => Hash::make($request->password)]);
    }
    
}