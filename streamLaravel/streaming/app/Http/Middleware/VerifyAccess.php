<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserSession;

class VerifyAccess
{
    // public function handle(Request $request, Closure $next)
    // {
    //     if (!session('verified')) {
    //         return redirect()->route('unauthorized');
    //     }

    //     return $next($request);
    // }



    public function handle(Request $request, Closure $next)
    {
        if (!session('verified')) {
            return redirect()->route('unauthorized');
        }

        return $next($request);
    }

}
