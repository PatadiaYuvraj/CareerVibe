<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        dd(auth()->guard('admin')->check());
        if (!(auth()->guard('user')->check() || auth()->guard('admin')->check() || auth()->guard('company')->check())) {
            return redirect()->route("admin.dashboard")->with("warning", "you're logged in ");
        }
        return $next($request);
    }
}
