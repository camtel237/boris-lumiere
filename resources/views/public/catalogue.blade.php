<x-layouts.public :title="'Catalogue — Boris Lumière'">

    <section class="max-w-6xl mx-auto px-4 py-10">
        <h1 class="font-display font-bold text-3xl text-navy mb-2">Catalogue</h1>
        <p class="text-muted mb-8">Prix indicatifs — la commande se finalise directement sur WhatsApp.</p>

        <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
            <label class="sr-only" for="catalogue-search">Rechercher un produit</label>
            <input id="catalogue-search" type="search" name="recherche" value="{{ $search }}"
                   placeholder="Rechercher un produit ou une référence..."
                   class="flex-1 rounded-lg border-line text-sm">
            @if($activeCategory)
                <input type="hidden" name="categorie" value="{{ $activeCategory }}">
            @endif
            <button type="submit" class="bg-navy text-white rounded-lg px-5 py-2.5 text-sm font-semibold hover:bg-navy-2">
                Rechercher
            </button>
        </form>

        <div class="flex flex-wrap gap-2 mb-8">
            <a href="{{ route('catalogue.index') }}"
               class="px-4 py-2 rounded-full text-sm font-medium border {{ $activeCategory === '' ? 'bg-navy text-white border-navy' : 'border-line text-ink hover:border-navy' }}">
                Tous
            </a>
            @foreach($categories as $category)
                <a href="{{ route('catalogue.index', ['categorie' => $category->slug]) }}"
                   class="px-4 py-2 rounded-full text-sm font-medium border {{ $activeCategory === $category->slug ? 'bg-navy text-white border-navy' : 'border-line text-ink hover:border-navy' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        @if($products->isEmpty())
            <p class="text-muted">Aucun produit dans cette catégorie pour le moment.</p>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @endif
    </section>

</x-layouts.public>
