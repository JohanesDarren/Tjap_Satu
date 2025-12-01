<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerNonAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = \Illuminate\Support\Facades\Auth::guard('customer');

        if ($guard->check() && ($guard->user()->is_admin ?? false)) {
            // Admin tidak boleh akses halaman customer, arahkan ke dashboard admin
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
