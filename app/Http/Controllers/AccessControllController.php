<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class AccessControllController extends Controller
{
    public function index() {
        return view('access');
    }

    public function access(Request $request) {
        if( $request->input('password') == "hack@tum" ) {
            $response = redirect()->route('home');
            $response->withCookie(cookie('access', '1', 24*60*30));
            return $response;
        }
        return redirect()->route('access');
    }
}
