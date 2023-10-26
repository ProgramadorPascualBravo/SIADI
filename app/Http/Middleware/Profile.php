<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Profile
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
         if ($request->id == Auth::id()) {
            return $next($request);
         }
         if (Auth::user()->can('user_detail'))
         {
            return $next($request);
         }
         return abort('403', 'User does not have the right permissions.');
    }
}
