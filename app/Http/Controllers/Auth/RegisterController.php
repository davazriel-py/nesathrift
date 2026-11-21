<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request, OtpService $otp)
    {
        $data = $request->validated();

        // Ekstrak NIM dari format email: nama.25051204123@mhs.unesa.ac.id
        $nim = preg_match('/\.(\d{8,})@/', $data['email'], $m) ? $m[1] : null;

        $user = User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'nim'           => $nim,
            'faculty'       => $data['faculty'] ?? null,
            'study_program' => $data['study_program'] ?? null,
            'whatsapp'      => $data['whatsapp'] ?? null,
            'password'      => $data['password'],
        ]);

        $otp->send($user);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('otp.notice')
            ->with('status', 'Kode OTP sudah dikirim ke ' . $user->email);
    }
}