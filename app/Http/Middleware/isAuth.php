<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        dd(Auth::guard('admin')->check());
        if (!(Auth::guard('user')->check() || Auth::guard('admin')->check() || Auth::guard('company')->check())) {
            return redirect()->route("admin.dashboard")->with("warning", "you're logged in ");
        }
        return $next($request);
    }
}
