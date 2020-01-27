<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function faq(){
        return view('frontend.faq');
    }

    public function instruction(){
        return view('frontend.instruction');
    }
}
