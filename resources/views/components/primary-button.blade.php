<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-orange border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-dark focus:bg-orange-dark active:bg-orange-dark focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
