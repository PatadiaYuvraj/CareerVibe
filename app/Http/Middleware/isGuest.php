<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('user')->check()) {
            // return redirect()->route("index")->with("warning", "you're logged in ");
            return redirect()->route("user.dashboard")->with("warning", "you're logged in ");
        }
        //admin
        if (auth()->guard('admin')->check()) {
            return redirect()->route("admin.dashboard")->with("warning", "you're logged in ");
        }
        // compay
        if (auth()->guard('company')->check()) {
            return redirect()->route("company.dashboard")->with("warning", "you're logged in ");
        }
        return $next($request);
    }
}
