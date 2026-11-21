@extends('layouts.guest')

@section('content')
<h1 class="text-xl font-semibold">Dashboard</h1>
<p class="text-sm text-slate-600 mt-2">Halaman ini hanya bisa dibuka akun yang sudah verifikasi OTP.</p>
<a href="{{ route('home') }}" class="text-blue-600 text-sm mt-4 inline-block">Kembali ke beranda</a>
@endsection