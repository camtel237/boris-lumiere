<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Boris Lumière — Matériel électrique à Douala' }}</title>
    <meta name="description" content="Boris Lumière : vente de câbles électriques, appareillages, vidéosurveillance, informatique et télécom à Douala. Commandez directement sur WhatsApp.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body text-ink antialiased bg-white" x-data="{ mobileNavOpen: false, cartOpen: false }" @keydown.escape.window="cartOpen = false">

    <div class="fixed top-0 inset-x-0 z-[60] h-1 border-t-4 border-dashed border-orange"></div>
    <header class="fixed top-1 inset-x-0 z-50 bg-navy text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-display font-bold text-lg shrink-0">
                <span class="w-9 h-9 rounded-lg bg-yellow text-navy grid place-items-center text-lg">⚡</span>
                <span class="hidden sm:inline">Boris Lumière</span>
            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="hover:text-yellow transition {{ request()->routeIs('home') ? 'text-yellow' : 'text-white/85' }}">Accueil</a>
                <a href="{{ route('home') }}#catalogue" class="hover:text-yellow transition">Catalogue</a>
                <a href="{{ route('home') }}#contact" class="hover:text-yellow transition">Contact</a>
                <a href="{{ route('home') }}#a-propos" class="hover:text-yellow transition">À propos</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="hidden sm:inline text-sm font-semibold hover:text-yellow">Connexion</a>
                <a href="https://wa.me/{{ config('services.whatsapp.number') }}" target="_blank" rel="noopener" class="hidden lg:inline text-sm font-semibold text-green-300 hover:text-white">WhatsApp</a>
                <button type="button" @click="cartOpen = true" class="relative flex items-center gap-2 text-sm font-semibold bg-white/10 hover:bg-white/20 transition rounded-lg px-3 py-2" aria-label="Ouvrir le panier">
                    <span aria-hidden="true">🛒</span>
                    <span class="hidden sm:inline">Panier</span>
                    @if(($cartCount ?? 0) > 0)
                        <span class="absolute -top-2 -right-2 bg-orange text-white text-xs font-bold rounded-full w-5 h-5 grid place-items-center">
                            {{ $cartCount }}
                        </span>
                    @endif
                </button>

                <button type="button" class="md:hidden p-2" @click="mobileNavOpen = !mobileNavOpen" aria-label="Ouvrir le menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <nav x-show="mobileNavOpen" x-cloak class="md:hidden bg-navy-2 border-t border-white/10 px-4 py-3 flex flex-col gap-3 text-sm font-medium">
            <a href="{{ route('home') }}" class="py-1">Accueil</a>
            <a href="{{ route('home') }}#catalogue" class="py-1">Catalogue</a>
            <a href="{{ route('home') }}#contact" class="py-1">Contact</a>
            <a href="{{ route('home') }}#a-propos" class="py-1">À propos</a>
            <a href="{{ route('login') }}" class="py-1 text-yellow">Connexion</a>
        </nav>
    </header>

    <main class="pt-[68px]">
        @if (session('success'))
            <div class="max-w-6xl mx-auto px-4 mt-4">
                <div class="bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg px-4 py-3">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-6xl mx-auto px-4 mt-4">
                <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg px-4 py-3">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="relative bg-navy text-white/70 mt-16 border-t-4 border-dashed border-orange">
        <div class="max-w-6xl mx-auto px-4 py-10 grid gap-8 sm:grid-cols-3 text-sm">
            <div>
                <div class="flex items-center gap-2 font-display font-bold text-white text-base mb-2">
                    <span class="w-8 h-8 rounded-lg bg-yellow text-navy grid place-items-center">⚡</span>
                    Boris Lumière
                </div>
                <p>La qualité supérieure au meilleur prix.</p>
            </div>
            <div>
                <h3 class="text-white font-semibold mb-2">Contact</h3>
                <p>(+237) 680 65 97 24</p>
                <p>(+237) 691 83 36 78</p>
                <p>ngouanetboris@gmail.com</p>
            </div>
            <div>
                <h3 class="text-white font-semibold mb-2">Adresse</h3>
                <p>En face Enéo Ndokoti,<br>derrière la SGBC banque, Douala</p>
            </div>
        </div>
        <div class="border-t border-white/10 text-center text-xs py-4">
            &copy; {{ now()->year }} Boris Lumière — tous droits réservés.
        </div>
    </footer>

    <x-whatsapp-float />

    <div x-show="cartOpen" x-cloak class="fixed inset-0 z-[70]" role="dialog" aria-modal="true" aria-label="Panier">
        <button type="button" class="absolute inset-0 bg-ink/50" @click="cartOpen = false" aria-label="Fermer le panier"></button>
        <aside x-show="cartOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl flex flex-col">
            <div class="flex items-center justify-between border-b border-line px-5 py-4">
                <h2 class="font-display font-bold text-xl text-navy">Votre panier</h2>
                <button type="button" @click="cartOpen = false" class="text-2xl text-muted hover:text-ink" aria-label="Fermer">&times;</button>
            </div>
            <div class="flex-1 overflow-y-auto p-5">
                @forelse($cartItems as $item)
                    @php($product = $item['product'])
                    <div class="flex items-center gap-3 border-b border-line py-3">
                        <img src="{{ $product->image_url }}" alt="" class="h-14 w-14 rounded-lg object-cover shrink-0">
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-semibold">{{ $product->name }}</p>
                            <p class="text-sm text-muted">{{ $item['quantity'] }} × {{ $product->formatted_price }}</p>
                        </div>
                        <form method="POST" action="{{ route('cart.remove', $product) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-sm text-red-500 hover:text-red-700" aria-label="Retirer {{ $product->name }}">&times;</button>
                        </form>
                    </div>
                @empty
                    <p class="py-12 text-center text-muted">Votre panier est vide.</p>
                @endforelse
            </div>
            <div class="border-t border-line p-5">
                <div class="mb-4 flex justify-between font-semibold"><span>Total indicatif</span><span class="text-navy">{{ number_format($cartTotal, 0, ',', ' ') }} FCFA</span></div>
                @if($cartItems->isNotEmpty())
                    <div class="grid gap-2 sm:grid-cols-2">
                        <a href="{{ route('cart.pdf') }}" class="block w-full rounded-lg border border-navy py-3 text-center text-sm font-semibold text-navy hover:bg-navy hover:text-white">Télécharger le PDF</a>
                        <a href="{{ $cartWhatsappLink }}" target="_blank" rel="noopener" class="block w-full rounded-lg bg-green-500 py-3 text-center text-sm font-semibold text-white hover:bg-green-600">Envoyer sur WhatsApp</a>
                    </div>
                @endif
            </div>
        </aside>
    </div>

</body>
</html>
