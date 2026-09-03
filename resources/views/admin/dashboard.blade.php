<x-layouts.admin :title="'Tableau de bord — Admin'">

    <h1 class="font-display font-bold text-2xl text-navy mb-6">Tableau de bord</h1>

    <div class="grid sm:grid-cols-2 gap-4 mb-8">
        <div class="bg-white border border-line rounded-xl p-5">
            <p class="text-3xl font-display font-bold text-navy">{{ $totalProducts }}</p>
            <p class="text-sm text-muted">Produits au catalogue</p>
        </div>
        <div class="bg-white border border-line rounded-xl p-5">
            <p class="text-3xl font-display font-bold text-navy">{{ $categoryBreakdown->count() }}</p>
            <p class="text-sm text-muted">Catégories</p>
        </div>
    </div>

    <div class="bg-white border border-line rounded-xl p-5">
        <h2 class="font-semibold text-ink mb-4">Répartition par catégorie</h2>
        <ul class="divide-y divide-line">
            @foreach($categoryBreakdown as $category)
                <li class="py-2 flex items-center justify-between text-sm">
                    <span>{{ $category->name }}</span>
                    <span class="font-semibold text-navy">{{ $category->products_count }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('admin.products.create') }}" class="bg-orange hover:bg-orange-dark text-white font-semibold rounded-lg px-5 py-2.5 text-sm transition">
            + Ajouter un produit
        </a>
        <a href="{{ route('admin.categories.create') }}" class="border border-navy text-navy font-semibold rounded-lg px-5 py-2.5 text-sm hover:bg-navy hover:text-white transition">
            + Ajouter une catégorie
        </a>
    </div>

</x-layouts.admin>
