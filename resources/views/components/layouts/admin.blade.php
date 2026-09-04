<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Espace Admin — Boris Lumière' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body bg-paper text-ink antialiased" x-data="{ mobileNavOpen: false, confirmOpen: false, confirmForm: null }" @keydown.escape.window="confirmOpen = false">

    <div class="h-1 border-t-4 border-dashed border-orange"></div>

    <div class="min-h-screen md:grid md:grid-cols-[220px_minmax(0,1fr)]">

        <aside class="bg-navy text-white p-4 sm:p-5 md:min-h-screen">
            <div class="flex items-center justify-between md:block">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-display font-bold">
                    <img src="{{ asset('images/logo_boris.png') }}" alt="" class="h-8 w-8 rounded-lg object-contain bg-white">
                    Boris Lumière
                </a>
                <button class="md:hidden p-2" @click="mobileNavOpen = !mobileNavOpen" aria-label="Menu">☰</button>
            </div>
            <p class="text-xs text-white/50 mt-1 mb-6 hidden md:block">Espace Admin</p>

            <nav class="flex flex-col gap-1 text-sm" :class="mobileNavOpen ? 'flex' : 'hidden md:flex'">
                <a href="{{ route('admin.dashboard') }}"
                   class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-white/70 hover:text-white' }}">
                    Tableau de bord
                </a>
                <a href="{{ route('admin.products.index') }}"
                   class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-white/10 text-white' : 'text-white/70 hover:text-white' }}">
                    Produits
                </a>
                <a href="{{ route('admin.categories.index') }}"
                   class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-white/10 text-white' : 'text-white/70 hover:text-white' }}">
                    Catégories
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="px-3 py-2 rounded-lg {{ request()->routeIs('profile.*') ? 'bg-white/10 text-white' : 'text-white/70 hover:text-white' }}">
                    Mon profil
                </a>

                <div class="border-t border-white/10 mt-4 pt-4">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg text-white/70 hover:text-white block">
                        ← Voir le site public
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-white/70 hover:text-white">
                            Se déconnecter
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <div class="min-w-0 p-4 sm:p-6 md:p-8">
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg px-4 py-3 mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg px-4 py-3 mb-6">
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>

    <div x-show="confirmOpen" x-cloak class="fixed inset-0 z-50 grid place-items-center bg-ink/50 px-4" role="dialog" aria-modal="true" aria-labelledby="confirm-title">
        <div x-show="confirmOpen" x-transition class="w-full max-w-sm rounded-xl border border-line bg-white p-6 shadow-2xl">
            <h2 id="confirm-title" class="font-display text-xl font-bold text-navy">Confirmer la suppression</h2>
            <p class="mt-2 text-sm text-muted">Cette action est définitive. Voulez-vous vraiment supprimer cet élément ?</p>
            <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                <button type="button" @click="confirmOpen = false" class="rounded-lg border border-line px-4 py-2.5 text-sm font-semibold text-ink hover:bg-paper">Annuler</button>
                <button type="button" @click="confirmForm.submit()" class="rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700">Supprimer</button>
            </div>
        </div>
    </div>

</body>
</html>
