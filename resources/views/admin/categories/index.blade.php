<x-layouts.admin :title="'Catégories — Admin'">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <h1 class="font-display font-bold text-2xl text-navy">Catégories</h1>
        <a href="{{ route('admin.categories.create') }}" class="w-full sm:w-auto text-center bg-orange hover:bg-orange-dark text-white font-semibold rounded-lg px-4 py-2 text-sm transition">
            + Ajouter une catégorie
        </a>
    </div>

    <div class="bg-white border border-line rounded-xl overflow-x-auto">
        <table class="w-full min-w-[520px] text-sm">
            <thead class="bg-paper text-left text-xs uppercase text-muted">
                <tr>
                    <th class="p-3">Nom</th>
                    <th class="p-3">Produits</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse($categories as $category)
                    <tr>
                        <td class="p-3 font-medium">{{ $category->name }}</td>
                        <td class="p-3 text-muted">{{ $category->products_count }}</td>
                        <td class="p-3 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-navy hover:underline">Modifier</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline" @submit.prevent="confirmForm = $el; confirmOpen = true">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="p-6 text-center text-muted">Aucune catégorie.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $categories->links() }}</div>

</x-layouts.admin>
