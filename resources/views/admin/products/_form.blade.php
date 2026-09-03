@csrf
@if($product ?? false)
    @method('PUT')
@endif

<div class="grid sm:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-ink mb-1">Nom du produit</label>
        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}"
               class="w-full rounded-lg border-line text-sm" required>
        <x-input-error :messages="$errors->get('name')" class="mt-1" />
    </div>

    <div>
        <label class="block text-sm font-medium text-ink mb-1">Référence (optionnel)</label>
        <input type="text" name="reference" value="{{ old('reference', $product->reference ?? '') }}"
               class="w-full rounded-lg border-line text-sm" placeholder="Ex : CAB-004">
        <x-input-error :messages="$errors->get('reference')" class="mt-1" />
    </div>

    <div>
        <label class="block text-sm font-medium text-ink mb-1">Catégorie</label>
        <select name="category_id" class="w-full rounded-lg border-line text-sm" required>
            <option value="">— Choisir —</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
    </div>

    <div>
        <label class="block text-sm font-medium text-ink mb-1">Prix (FCFA)</label>
        <input type="number" step="1" min="0" name="price" value="{{ old('price', $product->price ?? '') }}"
               class="w-full rounded-lg border-line text-sm" required>
        <x-input-error :messages="$errors->get('price')" class="mt-1" />
    </div>

</div>

<div class="mt-5">
    <label class="block text-sm font-medium text-ink mb-1">Description</label>
    <textarea name="description" rows="4" class="w-full rounded-lg border-line text-sm">{{ old('description', $product->description ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-1" />
</div>

<div class="mt-5">
    <label class="block text-sm font-medium text-ink mb-1">Photo du produit</label>

    @if(($product->image_path ?? false))
        <img src="{{ $product->image_url }}" alt="" class="w-24 h-24 rounded-lg object-cover mb-2">
    @endif

    <input type="file" name="image" accept="image/*" class="w-full text-sm">
    <p class="text-xs text-muted mt-1">Choisis une image depuis ta galerie (JPG/PNG, 4 Mo max). Elle sera affichée sur le site après l'enregistrement. Laisse vide pour garder la photo actuelle.</p>
    <x-input-error :messages="$errors->get('image')" class="mt-1" />
</div>

<div class="mt-5 flex items-center gap-2">
    <input type="checkbox" id="is_active" name="is_active" value="1"
           @checked(old('is_active', $product->is_active ?? true)) class="rounded border-line">
    <label for="is_active" class="text-sm text-ink">Visible sur le site public</label>
</div>

<div class="mt-8 flex gap-3">
    <button type="submit" class="bg-orange hover:bg-orange-dark text-white font-semibold rounded-lg px-6 py-2.5 text-sm transition">
        Enregistrer
    </button>
    <a href="{{ route('admin.products.index') }}" class="text-sm text-muted hover:text-ink px-4 py-2.5">
        Annuler
    </a>
</div>
