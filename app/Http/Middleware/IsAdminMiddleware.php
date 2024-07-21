<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                if ($request->is('admin*')) {
                    return $next($request);
                }

                return redirect('/admin');
            } else {
                if ($request->is('admin*')) {
                    return redirect('/account');
                }

                return $next($request);
            }
        }

        return $next($request);
    }
}
