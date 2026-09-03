<x-layouts.admin :title="'Ajouter un produit — Admin'">

    <div class="fixed inset-0 z-40 overflow-y-auto bg-ink/50 px-4 py-8 sm:py-12">
        <div class="mx-auto max-w-2xl rounded-xl border border-line bg-white p-5 shadow-2xl sm:p-6">
            <div class="mb-6 flex items-start justify-between gap-4">
                <h1 class="font-display font-bold text-2xl text-navy">Ajouter un produit</h1>
                <a href="{{ route('admin.products.index') }}" class="text-2xl leading-none text-muted hover:text-ink" aria-label="Fermer">&times;</a>
            </div>
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @include('admin.products._form', ['product' => null])
        </form>
        </div>
    </div>

</x-layouts.admin>
