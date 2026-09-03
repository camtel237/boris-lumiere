<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Site public
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalogue', [CatalogueController::class, 'index'])->name('catalogue.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::view('/a-propos', 'public.about')->name('about');
Route::get('/media/{path}', function (string $path) {
    $disk = Storage::disk('public');

    abort_if(str_contains($path, '..'), 404);
    abort_unless($disk->exists($path), 404);

    return response()->file($disk->path($path));
})->where('path', '.*')->name('media');

Route::prefix('panier')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/{product}', [CartController::class, 'store'])->name('add');
    Route::patch('/{product}', [CartController::class, 'update'])->name('update');
    Route::delete('/{product}', [CartController::class, 'destroy'])->name('remove');
    Route::get('/pdf', [CartController::class, 'downloadPdf'])->name('pdf');
});

/*
|--------------------------------------------------------------------------
| Compte (profil Breeze) — utilisé par le compte admin de Boris
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Espace Admin (protégé par connexion)
|--------------------------------------------------------------------------
| Note : on utilise uniquement le middleware 'auth' (pas 'verified') car
| il s'agit d'un back-office interne à un seul administrateur (Boris),
| pas d'inscriptions publiques nécessitant une vérification d'email.
*/

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('produits', AdminProductController::class)
            ->except(['show'])
            ->parameters(['produits' => 'product'])
            ->names('products');

        Route::resource('categories', AdminCategoryController::class)
            ->except(['show'])
            ->names('categories');
    });

// L'installation Breeze pointe vers /dashboard par défaut (menu, redirections
// après connexion) — on la redirige simplement vers le vrai tableau de bord.
Route::redirect('/dashboard', '/admin')->middleware('auth')->name('dashboard');

require __DIR__.'/auth.php';
