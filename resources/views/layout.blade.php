<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Reservasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
</head>
<body class="bg-gray-100 font-sans">
    <nav class="bg-blue-600 p-4 text-white flex justify-between">
        <a href="/" class="font-bold text-xl">BookingApp</a>
        <div>
            @auth
                <span class="mr-4">Halo, {{ Auth::user()->name }}</span>
                <a href="{{ route('logout') }}" class="bg-red-500 px-3 py-1 rounded">Logout</a>
            @else
                <a href="{{ route('login') }}" class="mr-4">Login</a>
                <a href="{{ route('register') }}" class="bg-green-500 px-3 py-1 rounded">Daftar</a>
            @endauth
        </div>
    </nav>

    <div class="container mx-auto p-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>