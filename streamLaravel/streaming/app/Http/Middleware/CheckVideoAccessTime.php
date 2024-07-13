<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckVideoAccessTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session('verified') || !session('verification_time')) {
            return redirect('/unauthorized');
        }

        $verificationTime = Carbon::parse(session('verification_time'));
        $currentTime = Carbon::now();

        if ($currentTime->diffInMinutes($verificationTime) < 10) {
            return redirect()->route('wait');
        }

        return $next($request);
    }
}
