<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'NesaThrift')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen">

<header class="sticky top-0 z-40 bg-white border-b shadow-sm">
    <div class="max-w-5xl mx-auto px-4 h-14 flex items-center justify-between gap-3">
        <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">NesaThrift</a>

        <nav class="flex items-center gap-2 sm:gap-4 text-sm">
            <a href="{{ route('dashboard') }}" class="font-medium hover:text-blue-600">Dashboard</a>
            <a href="{{ route('products.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-full px-3 sm:px-4 py-1.5">
                + Jual Barang
            </a>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-slate-500 hover:text-red-600">Keluar</button>
                </form>
            @endauth
        </nav>
    </div>
</header>

<main class="max-w-5xl mx-auto px-4 py-6">
    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-50 text-green-700 text-sm p-3">{{ session('status') }}</div>
    @endif
    @if ($errors->has('authorization'))
        <div class="mb-4 rounded-lg bg-red-50 text-red-700 text-sm p-3">{{ $errors->first('authorization') }}</div>
    @endif

    @yield('content')
</main>

</body>
</html>