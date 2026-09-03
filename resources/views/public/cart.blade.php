<x-layouts.public :title="'Mon panier — Boris Lumière'">

    <section class="max-w-3xl mx-auto px-4 py-10">
        <h1 class="font-display font-bold text-3xl text-navy mb-8">Mon panier</h1>

        @if($items->isEmpty())
            <div class="text-center py-16 border border-dashed border-line rounded-xl">
                <p class="text-muted mb-4">Votre panier est vide.</p>
                <a href="{{ route('catalogue.index') }}" class="text-orange font-semibold hover:text-orange-dark">
                    Parcourir le catalogue →
                </a>
            </div>
        @else
            <div class="divide-y divide-line border border-line rounded-xl overflow-hidden bg-white">
                @foreach($items as $item)
                    @php($product = $item['product'])
                    <div class="p-4 flex items-center gap-4">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-16 h-16 rounded-lg object-cover shrink-0">

                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-ink truncate">{{ $product->name }}</p>
                            <p class="text-sm text-muted">{{ $product->formatted_price }}</p>
                        </div>

                        <form method="POST" action="{{ route('cart.update', $product) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input
                                type="number"
                                name="quantity"
                                value="{{ $item['quantity'] }}"
                                min="0"
                                class="w-16 rounded-lg border-line text-sm"
                                onchange="this.form.submit()"
                            >
                        </form>

                        <p class="w-24 text-right font-semibold text-ink">
                            {{ number_format($item['subtotal'], 0, ',', ' ') }} FCFA
                        </p>

                        <form method="POST" action="{{ route('cart.remove', $product) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm" aria-label="Retirer">
                                ✕
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 bg-paper rounded-xl border border-line p-5">
                <div class="flex items-center justify-between mb-1">
                    <span class="font-semibold text-ink">Total indicatif</span>
                    <span class="font-display font-bold text-xl text-navy">
                        {{ number_format($total, 0, ',', ' ') }} FCFA
                    </span>
                </div>
                <p class="text-xs text-muted mb-4">
                    Prix indicatif — le prix final, le paiement et la livraison sont confirmés directement sur WhatsApp.
                </p>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('cart.pdf') }}"
                       class="flex-1 text-center border border-navy text-navy font-semibold rounded-lg py-3 hover:bg-navy hover:text-white transition">
                        ⬇ Télécharger le PDF de ma commande
                    </a>

                    <a href="{{ $whatsappCartLink }}" target="_blank" rel="noopener"
                       class="flex-1 text-center bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg py-3 transition">
                        Envoyer sur WhatsApp
                    </a>
                </div>
                <p class="text-xs text-muted mt-3">
                    N'oublie pas de joindre le PDF téléchargé directement dans la conversation WhatsApp.
                </p>
            </div>
        @endif
    </section>

</x-layouts.public>
