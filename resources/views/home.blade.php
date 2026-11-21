@extends('layouts.guest')

@section('content')
<h1 class="text-xl font-semibold mb-3">Beranda NesaThrift</h1>

@auth
    <p class="text-sm mb-1">Login sebagai <strong>{{ auth()->user()->name }}</strong></p>
    <p class="text-sm mb-4">
        Status:
        @if (auth()->user()->hasVerifiedOtp())
            <span class="text-green-600 font-medium">Terverifikasi</span>
        @else
            <a href="{{ route('otp.notice') }}" class="text-yellow-600 font-medium">Belum verifikasi OTP</a>
        @endif
    </p>
    <a href="{{ route('dashboard') }}" class="text-blue-600 text-sm">Coba halaman Dashboard (khusus terverifikasi)</a>
    <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button class="text-sm text-slate-500">Keluar</button>
    </form>
@else
    <a href="{{ route('login') }}" class="text-blue-600">Masuk</a> |
    <a href="{{ route('register') }}" class="text-blue-600">Daftar</a>
@endauth
@endsection