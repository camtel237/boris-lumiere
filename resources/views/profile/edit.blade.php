<x-layouts.admin :title="'Mon profil — Admin'">
    <div class="mb-8">
        <p class="text-sm font-semibold uppercase tracking-[.16em] text-orange">Compte administrateur</p>
        <h1 class="mt-2 font-display text-3xl font-bold text-navy">Mon profil</h1>
        <p class="mt-2 text-sm text-muted">Gérez vos informations personnelles et votre accès au dashboard.</p>
    </div>

    <div class="grid max-w-5xl gap-5 xl:grid-cols-2">
        <div class="rounded-xl border border-line bg-white p-5 sm:p-7">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="rounded-xl border border-line bg-white p-5 sm:p-7">
            @include('profile.partials.update-password-form')
        </div>
        <div class="rounded-xl border border-red-100 bg-red-50/50 p-5 sm:p-7 xl:col-span-2">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-layouts.admin>
