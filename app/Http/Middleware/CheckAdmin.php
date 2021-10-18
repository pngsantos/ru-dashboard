<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->user()->type == 'admin') {
            // Redirect...
            return redirect()->back()->with('error', 'You are not allowed to perform this action');
        }

        return $next($request);
    }
}
