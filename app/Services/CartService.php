<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

/**
 * Session-based shopping cart.
 *
 * No database table is used on purpose: the client never creates an
 * account, and no online payment happens on the site (see cahier des
 * charges §2.1). The cart only needs to survive the visitor's browsing
 * session, so Laravel's session store is the right amount of persistence.
 */
class CartService
{
    private const SESSION_KEY = 'cart';

    /**
     * Return the cart content as a collection of
     * ['product' => Product, 'quantity' => int, 'subtotal' => float].
     *
     * @return Collection<int, array{product: Product, quantity: int, subtotal: float}>
     */
    public function items(): Collection
    {
        $raw = $this->raw();

        if ($raw === []) {
            return collect();
        }

        $products = Product::query()
            ->whereIn('id', array_keys($raw))
            ->get()
            ->keyBy('id');

        return collect($raw)
            ->map(function (int $quantity, int $productId) use ($products) {
                /** @var Product|null $product */
                $product = $products->get($productId);

                if (! $product) {
                    return null;
                }

                return [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => (float) $product->price * $quantity,
                ];
            })
            ->filter()
            ->values();
    }

    public function add(int $productId, int $quantity = 1): void
    {
        $cart = $this->raw();
        $cart[$productId] = ($cart[$productId] ?? 0) + max(1, $quantity);
        $this->persist($cart);
    }

    public function setQuantity(int $productId, int $quantity): void
    {
        $cart = $this->raw();

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $quantity;
        }

        $this->persist($cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->raw();
        unset($cart[$productId]);
        $this->persist($cart);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function count(): int
    {
        return array_sum($this->raw());
    }

    public function total(): float
    {
        return (float) $this->items()->sum('subtotal');
    }

    /**
     * @return array<int, int> product_id => quantity
     */
    private function raw(): array
    {
        return session(self::SESSION_KEY, []);
    }

    /**
     * @param  array<int, int>  $cart
     */
    private function persist(array $cart): void
    {
        session([self::SESSION_KEY => $cart]);
    }
}
