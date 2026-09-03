<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Makes the cart item count available to the public layout on every
        // page, without every controller having to pass it explicitly.
        View::composer('components.layouts.public', function ($view): void {
            $cart = app(CartService::class);
            $cartItems = $cart->items();
            $cartTotal = (float) $cartItems->sum('subtotal');
            $cartLines = $cartItems->map(function (array $item): string {
                return $item['product']->name.' x '.$item['quantity'];
            })->implode("\n");
            $cartMessage = "Bonjour Boris Lumière,\n\nJe souhaite commander :\n\n"
                .$cartLines
                ."\n\nTotal indicatif : ".number_format($cartTotal, 0, ',', ' ').' FCFA';

            $view->with([
                'cartCount' => $cart->count(),
                'cartItems' => $cartItems,
                'cartTotal' => $cartTotal,
                'cartWhatsappLink' => 'https://wa.me/'.config('services.whatsapp.number').'?text='.urlencode($cartMessage),
            ]);
        });
    }
}
