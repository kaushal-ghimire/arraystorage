<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class isManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/');
        }
        if (Auth::user()->role == 0) {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::user()->role == 1) {
            return redirect()->route('user.dashboard');
        }

        if (Auth::user()->role == 2) {
            return $next($request);
        }

        
    }
    
}

