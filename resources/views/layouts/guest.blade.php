<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NesaThrift</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <a href="{{ route('home') }}" class="block text-center text-3xl font-bold text-blue-600 mb-6">NesaThrift</a>

        <div class="bg-white rounded-2xl shadow p-6 sm:p-8">
            @if (session('status'))
                <div class="mb-4 rounded-lg bg-green-50 text-green-700 text-sm p-3">{{ session('status') }}</div>
            @endif
            @if (session('warning'))
                <div class="mb-4 rounded-lg bg-yellow-50 text-yellow-800 text-sm p-3">{{ session('warning') }}</div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>