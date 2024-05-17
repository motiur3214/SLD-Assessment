<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsUserAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Check if the user is authenticated
        if ($request->user() && $request->user()->type === 'admin') {
            return $next($request);
        }

        // If not admin, redirect or return unauthorized response
        return redirect('/dashboard')->with('error', 'Unauthorized action.');
    }
}
