<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!auth('user')->check() || !auth('user')->user()->hasRole($role)) {
            return redirect()->route('home')->with('error', 'اجازه دسترسی ندارید');
        }
        return $next($request);
    }
}
