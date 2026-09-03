@props(['product'])

<div class="reveal border border-line rounded-xl overflow-hidden bg-white flex flex-col group transition hover:-translate-y-1 hover:shadow-lg">
    <div class="aspect-[4/3] bg-paper overflow-hidden">
        <img
            src="{{ $product->image_url }}"
            alt="{{ $product->name }}"
            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
            loading="lazy"
        >
    </div>

    <div class="p-4 flex flex-col gap-2 flex-1">
        <span class="text-xs uppercase tracking-wide text-muted font-semibold">
            {{ $product->category->name }}
        </span>

        <h3 class="font-display font-semibold text-ink leading-snug">{{ $product->name }}</h3>

        @if($product->description)
            <p class="text-sm text-muted line-clamp-2">{{ $product->description }}</p>
        @endif

        <div class="mt-auto pt-2 flex items-center justify-between gap-2">
            <span class="text-orange-dark font-semibold text-sm">{{ $product->formatted_price }}</span>

        </div>

        <form method="POST" action="{{ route('cart.add', $product) }}" class="pt-1">
            @csrf
            <button
                type="submit"
                class="w-full text-sm font-semibold rounded-lg py-2 transition bg-navy text-white hover:bg-navy-2"
            >
                Ajouter au panier
            </button>
        </form>
    </div>
</div>
