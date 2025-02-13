<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->check() && $request->user() && $request->user()->is_admin && $request->user()->hasRole('admin')) {
            return $next($request);
        }

        return redirect('/'); // Redirect to a desired page if not an admin
    }
}
