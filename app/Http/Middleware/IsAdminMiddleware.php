<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
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
        if (auth()->check()) {
            if (auth()->user()->hasRole(UserRole::ADMIN)) {
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
