<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccessControll
{
    public function handle(Request $request, Closure $next)
    {
        // Nur bei gesetztem Cookie erlauben
        if( !$request->cookie('access') ) {
            return redirect()->route('access');
        } else {
            return $next($request);
        }
    }
}
