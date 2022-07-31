<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && (auth()->user()->user_type == "admin" || auth()->user()->user_type == "staff")) {
            return $next($request);
        }
        else {
            return redirect()->route('admin.login');
        }
    }
}
