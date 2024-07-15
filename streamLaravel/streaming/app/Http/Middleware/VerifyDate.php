<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VerifyDate
{
    public function handle(Request $request, Closure $next)
    {
        $availabilityStart = session('availability_start');
        $availabilityEnd = session('availability_end');

        if (!$availabilityStart || !$availabilityEnd) {
            return redirect('/unauthorized');
        }

        $availabilityStart = Carbon::parse($availabilityStart);
        $availabilityEnd = Carbon::parse($availabilityEnd);
        $currentDate = Carbon::now();

        if ($currentDate->lt($availabilityStart)) {
            return redirect()->route('waiting');
        }

        if ($currentDate->gt($availabilityEnd)) {
            return redirect()->route('expired');
        }

        return $next($request);
    }
}
