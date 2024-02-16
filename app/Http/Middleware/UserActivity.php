<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if (Auth::check()) {
            $expiresAt = now()->addMinutes(15); /* keep online for 15 min */
            Cache::put(Auth::user()->name . '-online', true, $expiresAt);
  
            /* last seen */
            User::where('username', Auth::user()->name)->update(['last_seen' => now()]);
        }
  

        return $next($request);
    }
}
