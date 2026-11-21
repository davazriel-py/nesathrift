@extends('layouts.guest')

@section('content')
<h1 class="text-xl font-semibold mb-1">Daftar Akun</h1>
<p class="text-sm text-slate-500 mb-5">Khusus mahasiswa UNESA (@mhs.unesa.ac.id)</p>

<form method="POST" action="{{ route('register') }}" class="space-y-4">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name') }}" required
               class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Email UNESA</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama.nim@mhs.unesa.ac.id" required
               class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Fakultas</label>
            <input type="text" name="faculty" value="{{ old('faculty') }}"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Prodi</label>
            <input type="text" name="study_program" value="{{ old('study_program') }}"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">No. WhatsApp</label>
        <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="08xxxxxxxxxx"
               class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('whatsapp') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Password</label>
        <input type="password" name="password" required
               class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" required
               class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg py-2.5">Daftar</button>
</form>

<p class="text-sm text-center text-slate-600 mt-5">
    Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-medium">Masuk</a>
</p>
@endsection