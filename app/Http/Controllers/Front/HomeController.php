<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Banner;
use App\Mail\BookingMessage;
class HomeController extends Controller
{
    public function homePage(){ 
        $data['getBanner'] = Banner::active()->ordered()->get();
        return view('pages.home', $data);
    }






}