<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompletedProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        session('auth');
        if (session('auth.first_name') != null) {
            return $next($request);
        } else {
            return redirect()->route('user.profile.index')->with('error', 'Please Complete Your Profile First');
        }
    }
}
