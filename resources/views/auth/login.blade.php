@extends('layouts.guest')

@section('content')
<h1 class="text-xl font-semibold mb-5">Masuk</h1>

<form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Email UNESA</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus
               class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Password</label>
        <input type="password" name="password" required
               class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="remember" class="rounded"> Ingat saya
    </label>

    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg py-2.5">Masuk</button>
</form>

<p class="text-sm text-center text-slate-600 mt-5">
    Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 font-medium">Daftar</a>
</p>
@endsection