<x-layouts.admin :title="'Produits — Admin'">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <h1 class="font-display font-bold text-2xl text-navy">Produits</h1>
        <a href="{{ route('admin.products.create') }}" class="w-full sm:w-auto text-center bg-orange hover:bg-orange-dark text-white font-semibold rounded-lg px-4 py-2 text-sm transition">
            + Ajouter un produit
        </a>
    </div>

    <form method="GET" class="grid gap-3 mb-6 sm:grid-cols-[1fr_auto_auto]">
        <input
            type="text"
            name="recherche"
            value="{{ request('recherche') }}"
            placeholder="Rechercher un produit..."
            class="rounded-lg border-line text-sm min-w-0"
        >
        <select name="categorie" class="rounded-lg border-line text-sm" onchange="this.form.submit()">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(request('categorie') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="border border-navy text-navy rounded-lg px-4 py-2 text-sm font-semibold">
            Filtrer
        </button>
    </form>

    <div class="hidden md:block bg-white border border-line rounded-xl overflow-x-auto">
        <table class="w-full min-w-[720px] text-sm">
            <thead class="bg-paper text-left text-xs uppercase text-muted">
                <tr>
                    <th class="p-3">Produit</th>
                    <th class="p-3">Catégorie</th>
                    <th class="p-3">Prix</th>
                    <th class="p-3">Statut</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse($products as $product)
                    <tr>
                        <td class="p-3 flex items-center gap-3">
                            <img src="{{ $product->image_url }}" class="w-10 h-10 rounded-lg object-cover" alt="">
                            <span class="font-medium">{{ $product->name }}</span>
                        </td>
                        <td class="p-3 text-muted">{{ $product->category->name }}</td>
                        <td class="p-3">{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                        <td class="p-3">
                            @if($product->is_active)
                                <span class="text-xs bg-green-50 text-green-700 rounded-full px-2 py-1">Actif</span>
                            @else
                                <span class="text-xs bg-gray-100 text-gray-500 rounded-full px-2 py-1">Masqué</span>
                            @endif
                        </td>
                        <td class="p-3 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-navy hover:underline">Modifier</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" @submit.prevent="confirmForm = $el; confirmOpen = true">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-muted">Aucun produit trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="grid gap-3 md:hidden">
        @forelse($products as $product)
            <div class="rounded-xl border border-line bg-white p-4 shadow-sm">
                <div class="flex items-start gap-3">
                    <img src="{{ $product->image_url }}" class="h-16 w-16 shrink-0 rounded-lg object-cover" alt="">
                    <div class="min-w-0 flex-1">
                        <h2 class="truncate font-semibold text-ink">{{ $product->name }}</h2>
                        <p class="mt-1 text-sm text-muted">{{ $product->category->name }}</p>
                        <p class="mt-2 font-semibold text-navy">{{ number_format($product->price, 0, ',', ' ') }} FCFA</p>
                    </div>
                    @if($product->is_active)
                        <span class="shrink-0 rounded-full bg-green-50 px-2 py-1 text-xs text-green-700">Actif</span>
                    @else
                        <span class="shrink-0 rounded-full bg-gray-100 px-2 py-1 text-xs text-gray-500">Masqué</span>
                    @endif
                </div>

                <div class="mt-4 border-t border-line pt-3 text-sm">
                    <div>
                        <span class="block text-xs text-muted">Référence</span>
                        <span class="truncate font-medium">{{ $product->reference ?: '—' }}</span>
                    </div>
                </div>

                <div class="mt-4 flex items-center gap-4 border-t border-line pt-3 text-sm font-semibold">
                    <a href="{{ route('admin.products.edit', $product) }}" class="text-navy hover:underline">Modifier</a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" @submit.prevent="confirmForm = $el; confirmOpen = true">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Supprimer</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="rounded-xl border border-line bg-white p-6 text-center text-muted">Aucun produit trouvé.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $products->links() }}</div>

</x-layouts.admin>
