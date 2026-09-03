<x-layouts.public :title="'Boris Lumière — La qualité supérieure au meilleur prix'">

    <section class="reveal bg-gradient-to-b from-white to-orange/5 border-b border-line">
        <div class="max-w-6xl mx-auto px-4 py-16 grid md:grid-cols-2 gap-10 items-center">
            <div class="reveal reveal-delay-1">
                <p class="text-sm font-semibold text-muted mb-3">Douala · En face Enéo Ndokoti, derrière la SGBC</p>
                <h1 class="font-display font-bold text-4xl md:text-5xl leading-tight text-navy">
                    La qualité supérieure <span class="text-orange">au meilleur prix</span>
                </h1>
                <p class="mt-5 text-muted text-lg max-w-md">
                    Câbles, appareillages électriques, informatique, vidéosurveillance et télécom —
                    tout pour vos installations, dans un seul endroit.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#catalogue" class="cta-pulse bg-orange hover:bg-orange-dark text-white font-semibold rounded-lg px-6 py-3 transition">
                        Découvrir le catalogue
                    </a>
                    <a href="#contact" class="border border-navy text-navy font-semibold rounded-lg px-6 py-3 hover:bg-navy hover:text-white transition">
                        Nous localiser
                    </a>
                </div>
            </div>
            <div class="hidden md:grid grid-cols-2 gap-4 reveal reveal-delay-2">
                @php
                    $categoryImages = [
                        'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?auto=format&fit=crop&w=900&q=85',
                         'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=900&q=85',
                        'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=900&q=85',
                       'https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=900&q=85',
                    ];
                @endphp
                @foreach($categories->take(4) as $category)
                    <div class="hero-drift relative overflow-hidden rounded-xl bg-navy text-white aspect-square flex flex-col justify-end p-5" style="animation-delay: {{ $loop->index * 180 }}ms">
                        <img src="{{ $categoryImages[$loop->index] }}" alt="{{ $category->name }}" class="absolute inset-0 h-full w-full object-cover transition duration-700 hover:scale-110" loading="eager">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy via-navy/35 to-transparent"></div>
                        <div class="relative">
                            <span class="font-display font-semibold">{{ $category->name }}</span>
                            <span class="block text-xs text-white/75">{{ $category->active_products_count }} produits</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="reveal max-w-6xl mx-auto px-4 py-14">
        <h2 class="font-display font-bold text-2xl text-navy mb-6">Nos familles de produits</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($categories as $category)
                     <a href="#catalogue"
                         class="reveal reveal-delay-{{ $loop->iteration }} border border-line rounded-xl p-5 hover:border-orange hover:-translate-y-1 transition bg-white">
                    <h3 class="font-display font-semibold text-ink">{{ $category->name }}</h3>
                    <p class="text-sm text-muted mt-1">{{ $category->active_products_count }} produit(s)</p>
                </a>
            @endforeach
        </div>
    </section>

    <section id="catalogue" class="reveal scroll-mt-24 bg-paper border-y border-line" x-data="{ carousel: null, interval: null, move(direction) { this.carousel.scrollBy({ left: direction * this.carousel.clientWidth * .82, behavior: 'smooth' }) } }" x-init="carousel = $refs.carousel; interval = setInterval(() => move(1), 4500)" @mouseenter="clearInterval(interval)" @mouseleave="interval = setInterval(() => move(1), 4500)">
        <div class="max-w-6xl mx-auto px-4 py-14">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[.16em] text-orange">Catalogue</p>
                    <h2 class="mt-1 font-display font-bold text-2xl text-navy">Tout notre catalogue</h2>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" @click="move(-1)" class="h-9 w-9 rounded-full border border-line text-navy hover:border-orange hover:text-orange" aria-label="Produits précédents">←</button>
                    <button type="button" @click="move(1)" class="h-9 w-9 rounded-full border border-line text-navy hover:border-orange hover:text-orange" aria-label="Produits suivants">→</button>
                </div>
            </div>
            <form method="GET" action="{{ route('home') }}#catalogue" class="flex flex-col sm:flex-row gap-3 mb-5">
                <label class="sr-only" for="catalogue-search">Rechercher un produit</label>
                <input id="catalogue-search" type="search" name="recherche" value="{{ $search }}" placeholder="Rechercher un produit ou une référence..." class="min-w-0 flex-1 rounded-lg border-line text-sm">
                @if($activeCategory)
                    <input type="hidden" name="categorie" value="{{ $activeCategory }}">
                @endif
                <button type="submit" class="rounded-lg bg-navy px-5 py-2.5 text-sm font-semibold text-white hover:bg-navy-2">Rechercher</button>
            </form>
            <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
                <a href="{{ route('home') }}#catalogue" class="shrink-0 rounded-full border px-4 py-2 text-sm font-medium {{ $activeCategory === '' ? 'bg-navy text-white border-navy' : 'border-line text-ink hover:border-navy' }}">Tous</a>
                @foreach($categories as $category)
                    <a href="{{ route('home', ['categorie' => $category->slug]) }}#catalogue" class="shrink-0 rounded-full border px-4 py-2 text-sm font-medium {{ $activeCategory === $category->slug ? 'bg-navy text-white border-navy' : 'border-line text-ink hover:border-navy' }}">{{ $category->name }}</a>
                @endforeach
            </div>
            @if($products->isEmpty())
                <p class="mt-8 text-muted">Aucun produit ne correspond à votre recherche.</p>
            @else
            <div x-ref="carousel" class="flex gap-5 overflow-x-auto snap-x snap-mandatory pb-4 scrollbar-hide">
                @foreach($products as $product)
                    <div class="min-w-[78%] sm:min-w-[42%] lg:min-w-[23.5%] snap-start reveal"><x-product-card :product="$product" /></div>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    <section id="a-propos" class="reveal scroll-mt-24 bg-navy text-white">
        <div class="max-w-6xl mx-auto px-4 py-16 grid md:grid-cols-[1.1fr_.9fr] gap-10 items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[.16em] text-yellow">À propos de Boris Lumière</p>
                <h2 class="mt-3 font-display font-bold text-3xl md:text-4xl">Des solutions fiables pour vos installations.</h2>
                <p class="mt-5 max-w-2xl text-white/70 leading-relaxed">Nous sélectionnons du matériel électrique, de la vidéosurveillance et des équipements informatiques pour accompagner les particuliers, les professionnels et les installateurs à Douala.</p>
            </div>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div class="reveal reveal-delay-1 border border-white/15 p-4 transition hover:-translate-y-1 hover:border-yellow"><strong class="block text-yellow text-2xl font-display">01</strong><span class="text-white/70">Conseil au choix</span></div>
                <div class="reveal reveal-delay-2 border border-white/15 p-4 transition hover:-translate-y-1 hover:border-yellow"><strong class="block text-yellow text-2xl font-display">02</strong><span class="text-white/70">Produits sélectionnés</span></div>
                <div class="reveal reveal-delay-3 border border-white/15 p-4 transition hover:-translate-y-1 hover:border-yellow"><strong class="block text-yellow text-2xl font-display">03</strong><span class="text-white/70">Commande simple</span></div>
                <div class="reveal reveal-delay-4 border border-white/15 p-4 transition hover:-translate-y-1 hover:border-yellow"><strong class="block text-yellow text-2xl font-display">04</strong><span class="text-white/70">Échange direct</span></div>
            </div>
        </div>
    </section>

    <section id="contact" class="reveal scroll-mt-24 max-w-6xl mx-auto px-4 py-16">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-[.16em] text-orange">Contact</p>
            <h2 class="mt-2 font-display font-bold text-3xl text-navy">Parlons de votre projet.</h2>
        </div>
        <div class="grid gap-8 md:grid-cols-2">
            <div class="space-y-5">
                <div><h3 class="font-semibold text-ink">Adresse</h3><p class="text-muted">En face Enéo Ndokoti, derrière la SGBC banque, Douala</p></div>
                <div><h3 class="font-semibold text-ink">Téléphone / WhatsApp</h3><p class="text-muted"><a href="tel:+237680659724" class="hover:text-orange">(+237) 680 65 97 24</a><br><a href="tel:+237691833678" class="hover:text-orange">(+237) 691 83 36 78</a></p></div>
                <div><h3 class="font-semibold text-ink">Email</h3><a href="mailto:ngouanetboris@gmail.com" class="text-muted hover:text-orange">ngouanetboris@gmail.com</a></div>
                <div><h3 class="font-semibold text-ink">Horaires</h3><p class="text-muted">Lundi – Samedi, 8h – 18h</p></div>
            </div>
            <div class="overflow-hidden rounded-xl border border-line bg-paper">
                <iframe
                    title="Localisation de Boris Lumière à Ndokoti, Douala"
                    src="https://www.google.com/maps?q=En%C3%A9o+Ndokoti%2C+Douala%2C+Cameroun&output=embed"
                    class="h-64 w-full border-0 sm:h-80"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </div>
        </div>
    </section>

  

</x-layouts.public>
