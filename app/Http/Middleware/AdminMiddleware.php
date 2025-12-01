<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth = \Illuminate\Support\Facades\Auth::guard('customer');
        if (!$auth->check() || !$auth->user()->is_admin) {
            return redirect()->route('home', ['login' => 1])
                ->with('show_login', true)
                ->with('admin_login', true);
        }

        return $next($request);
    }
}
