<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function show(Request $request, OtpService $otp)
    {
        $user = $request->user();

        if ($user->hasVerifiedOtp()) {
            return redirect()->route('home');
        }

        return view('auth.verify-otp', [
            'cooldown' => $otp->cooldownRemaining($user),
        ]);
    }

    public function verify(Request $request, OtpService $otp)
    {
        $request->validate(['otp' => ['required', 'digits:6']], [
            'otp.digits' => 'Kode OTP harus 6 digit angka.',
        ]);

        if (! $otp->verify($request->user(), $request->otp)) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa.']);
        }

        return redirect()->route('home')->with('status', 'Akun berhasil diverifikasi. Selamat datang!');
    }

    public function resend(Request $request, OtpService $otp)
    {
        $user = $request->user();

        if ($user->hasVerifiedOtp()) {
            return redirect()->route('home');
        }

        if ($otp->cooldownRemaining($user) > 0) {
            return back()->withErrors([
                'otp' => 'Tunggu ' . $otp->cooldownRemaining($user) . ' detik sebelum kirim ulang.',
            ]);
        }

        $otp->send($user);

        return back()->with('status', 'Kode OTP baru sudah dikirim.');
    }
}