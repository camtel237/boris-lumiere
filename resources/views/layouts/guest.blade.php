<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Boris Lumière') }} — Espace admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body bg-navy min-h-screen flex flex-col items-center justify-center px-4 py-10">

    <a href="{{ route('home') }}" class="flex items-center gap-2 text-white font-display font-bold text-xl mb-8">
        <img src="{{ asset('images/logo_boris.png') }}" alt="" class="h-10 w-10 rounded-lg object-contain bg-white">
        Boris Lumière
    </a>

    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-2xl p-8">
            {{ $slot }}
        </div>
        <p class="text-center text-white/40 text-xs mt-6">Espace réservé à l'administration du catalogue.</p>
    </div>

</body>
</html>
