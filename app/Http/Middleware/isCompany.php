<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('company')->check() && auth()->guard('company')->user()->userType === "COMPANY") {
            // dd(auth()->guard('company')->check());
            return $next($request);
        } else {
            return redirect()->route("company.login")->with("warning", "you're logged out ");
        }
        return $next($request);
    }
}
