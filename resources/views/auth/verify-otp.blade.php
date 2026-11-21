@extends('layouts.guest')

@section('content')
<h1 class="text-xl font-semibold mb-1">Verifikasi Email</h1>
<p class="text-sm text-slate-500 mb-5">
    Masukkan 6 digit kode yang dikirim ke <strong>{{ auth()->user()->email }}</strong>.
</p>

<form method="POST" action="{{ route('otp.verify') }}" class="space-y-4">
    @csrf
    <input type="text" name="otp" inputmode="numeric" maxlength="6" autocomplete="one-time-code" required autofocus
           class="w-full text-center text-2xl tracking-[0.5em] rounded-lg border border-slate-300 px-3 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
    @error('otp') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg py-2.5">Verifikasi</button>
</form>

<form method="POST" action="{{ route('otp.resend') }}" class="mt-4 text-center">
    @csrf
    <button id="resendBtn" class="text-sm text-blue-600 font-medium disabled:text-slate-400 disabled:cursor-not-allowed">
        Kirim ulang OTP <span id="countdown"></span>
    </button>
</form>

<form method="POST" action="{{ route('logout') }}" class="mt-3 text-center">
    @csrf
    <button class="text-sm text-slate-500">Keluar</button>
</form>

<script>
    let sisa = {{ $cooldown }};
    const btn = document.getElementById('resendBtn');
    const label = document.getElementById('countdown');

    function tick() {
        if (sisa > 0) {
            btn.disabled = true;
            label.textContent = '(' + sisa + 'd)';
            sisa--;
            setTimeout(tick, 1000);
        } else {
            btn.disabled = false;
            label.textContent = '';
        }
    }
    tick();
</script>
@endsection