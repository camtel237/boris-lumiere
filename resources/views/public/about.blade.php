<x-layouts.public :title="'À propos — Boris Lumière'">
    <section class="reveal max-w-4xl mx-auto px-4 py-14">
        <p class="text-sm font-semibold uppercase tracking-[.16em] text-orange">Notre histoire</p>
        <h1 class="mt-3 font-display font-bold text-3xl md:text-4xl text-navy">Boris Lumière, votre partenaire matériel à Douala.</h1>
        <p class="mt-6 max-w-2xl text-lg leading-relaxed text-muted">Nous mettons à votre disposition une sélection claire de matériel électrique, de solutions de vidéosurveillance et d'équipements informatiques pour vos projets du quotidien.</p>

        <div class="mt-12 grid gap-6 sm:grid-cols-3">
            <div class="border-t-4 border-orange pt-4">
                <h2 class="font-display font-bold text-lg text-navy">Expertise</h2>
                <p class="mt-2 text-sm leading-relaxed text-muted">Des produits choisis pour répondre aux besoins des installateurs, entreprises et particuliers.</p>
            </div>
            <div class="border-t-4 border-yellow pt-4">
                <h2 class="font-display font-bold text-lg text-navy">Proximité</h2>
                <p class="mt-2 text-sm leading-relaxed text-muted">Un échange direct pour vous orienter rapidement vers la bonne solution.</p>
            </div>
            <div class="border-t-4 border-navy pt-4">
                <h2 class="font-display font-bold text-lg text-navy">Simplicité</h2>
                <p class="mt-2 text-sm leading-relaxed text-muted">Consultez le catalogue, composez votre demande et finalisez simplement sur WhatsApp.</p>
            </div>
        </div>

        <div class="mt-12 rounded-xl bg-paper border border-line p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
            <div>
                <h2 class="font-display font-bold text-xl text-navy">Un projet en tête ?</h2>
                <p class="mt-1 text-sm text-muted">Retrouvez-nous à Ndokoti ou contactez-nous directement.</p>
            </div>
            <a href="{{ route('contact') }}" class="shrink-0 rounded-lg bg-orange px-5 py-3 text-center text-sm font-semibold text-white hover:bg-orange-dark transition">Nous contacter</a>
        </div>
    </section>
</x-layouts.public>
