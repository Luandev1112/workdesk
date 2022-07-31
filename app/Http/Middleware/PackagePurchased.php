<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon;

class PackagePurchased
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
        if (Auth::user()->userPackage == null || (Auth::user()->userPackage->package_invalid_at != null && Carbon::now()->diffInDays(Carbon::parse(Auth::user()->userPackage->package_invalid_at), false) <= 0)) {
            return redirect()->route('select_package');
        }

        return $next($request);
    }
}
