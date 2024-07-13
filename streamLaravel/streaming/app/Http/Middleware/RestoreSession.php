<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserSession;

class RestoreSession
{
    public function handle(Request $request, Closure $next)
    {
        if ($paymentId = session('payment_id')) {
            $userSessions = UserSession::where('payment_id', $paymentId)->get();
            foreach ($userSessions as $userSession) {
                session([$userSession->session_key => $userSession->session_value]);
            }
        }

        return $next($request);
    }
}
