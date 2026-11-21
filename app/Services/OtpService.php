<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    public const TTL_MINUTES      = 10;
    public const COOLDOWN_SECONDS = 60;

    public function send(User $user): void
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->forceFill([
            'otp_code'       => Hash::make($code),
            'otp_expires_at' => now()->addMinutes(self::TTL_MINUTES),
            'otp_sent_at'    => now(),
        ])->save();

        Mail::to($user->email)->send(new OtpMail($user, $code, self::TTL_MINUTES));
    }

    public function verify(User $user, string $input): bool
    {
        if (! $user->otp_code || ! $user->otp_expires_at || $user->otp_expires_at->isPast()) {
            return false;
        }

        if (! Hash::check($input, $user->otp_code)) {
            return false;
        }

        $user->forceFill([
            'email_verified_at' => now(),
            'otp_code'          => null,
            'otp_expires_at'    => null,
            'otp_sent_at'       => null,
        ])->save();

        return true;
    }

    public function cooldownRemaining(User $user): int
    {
        if (! $user->otp_sent_at) {
            return 0;
        }

        return max(0, self::COOLDOWN_SECONDS - (int) $user->otp_sent_at->diffInSeconds(now()));
    }
}