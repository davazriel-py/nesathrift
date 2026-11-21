<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOtpVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->hasVerifiedOtp()) {
            return redirect()
                ->route('otp.notice')
                ->with('warning', 'Verifikasi email UNESA kamu dulu untuk mengakses fitur ini.');
        }

        return $next($request);
    }
}