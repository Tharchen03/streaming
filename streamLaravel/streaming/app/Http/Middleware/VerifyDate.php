<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VerifyDate
{
    // public function handle(Request $request, Closure $next)
    // {
    //     $availabilityDate = session('availability_date');

    //     if (!$availabilityDate) {
    //         return redirect('/unauthorized');
    //     }

    //     $availabilityDate = Carbon::parse($availabilityDate);
    //     $currentDate = Carbon::now();

    //     if ($currentDate->lt($availabilityDate)) {
    //         return redirect()->route('waiting');
    //     }

    //     return $next($request);
    // }

    public function handle(Request $request, Closure $next)
    {
        $availabilityDate = session('availability_date');

        if (!$availabilityDate) {
            return redirect()->route('unauthorized');
        }

        $availabilityDate = Carbon::parse($availabilityDate);
        $currentDate = Carbon::now();

        if ($currentDate->lt($availabilityDate)) {
            return redirect()->route('waiting');
        }

        return $next($request);
    }
}
