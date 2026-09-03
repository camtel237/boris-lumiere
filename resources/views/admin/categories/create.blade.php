<x-layouts.admin :title="'Ajouter une catégorie — Admin'">

    <div class="fixed inset-0 z-40 overflow-y-auto bg-ink/50 px-4 py-8 sm:py-12">
        <div class="mx-auto max-w-md rounded-xl border border-line bg-white p-5 shadow-2xl sm:p-6">
            <div class="mb-6 flex items-start justify-between gap-4">
                <h1 class="font-display font-bold text-2xl text-navy">Ajouter une catégorie</h1>
                <a href="{{ route('admin.categories.index') }}" class="text-2xl leading-none text-muted hover:text-ink" aria-label="Fermer">&times;</a>
            </div>
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <label class="block text-sm font-medium text-ink mb-1">Nom de la catégorie</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border-line text-sm" required>
            <x-input-error :messages="$errors->get('name')" class="mt-1" />

            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-orange hover:bg-orange-dark text-white font-semibold rounded-lg px-6 py-2.5 text-sm transition">
                    Enregistrer
                </button>
                <a href="{{ route('admin.categories.index') }}" class="text-sm text-muted hover:text-ink px-4 py-2.5">Annuler</a>
            </div>
        </form>
        </div>
    </div>

</x-layouts.admin>
