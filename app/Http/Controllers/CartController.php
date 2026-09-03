<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cart)
    {
    }

    public function index()
    {
        $items = $this->cart->items();

        return view('public.cart', [
            'items' => $items,
            'total' => $this->cart->total(),
            'whatsappCartLink' => $this->buildWhatsappLink($items, $this->cart->total()),
        ]);
    }

    /**
     * Build a wa.me link with a pre-filled text summary of the cart.
     * WhatsApp links cannot carry an attachment, so the message reminds
     * the client to attach the PDF they just downloaded (see §2.3 of the
     * cahier des charges).
     */
    private function buildWhatsappLink($items, float $total): string
    {
        $number = config('services.whatsapp.number');

        $lines = $items->map(function (array $item) {
            $product = $item['product'];

            return sprintf(
                '• %s — %d x %s',
                $product->name,
                $item['quantity'],
                $product->formatted_price
            );
        })->implode("\n");

        $message = "Bonjour Boris Lumière,\n\nJe souhaite passer la commande suivante :\n\n"
            .$lines
            ."\n\nTotal indicatif : ".number_format($total, 0, ',', ' ')." FCFA"
            ."\n\n📎 Je joins le PDF de ma commande téléchargé depuis votre site."
            ."\nMerci de me confirmer le prix final, le paiement et la livraison.";

        return "https://wa.me/{$number}?text=".urlencode($message);
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $this->cart->add($product->id, $validated['quantity'] ?? 1);

        return back()->with('success', "« {$product->name} » ajouté au panier.");
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $this->cart->setQuantity($product->id, $validated['quantity']);

        return back();
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->cart->remove($product->id);

        return back()->with('success', 'Produit retiré du panier.');
    }

    /**
     * Generate a downloadable PDF summary of the current cart, so the
     * client can attach it to the WhatsApp conversation (see cahier des
     * charges §2.2 — WhatsApp itself cannot receive a file via a plain
     * link, so the download-then-attach flow is the deliberate design).
     */
    public function downloadPdf()
    {
        $items = $this->cart->items();

        abort_if($items->isEmpty(), 400, 'Le panier est vide.');

        $pdf = Pdf::loadView('pdf.order', [
            'items' => $items,
            'total' => $this->cart->total(),
            'date' => now()->translatedFormat('d/m/Y'),
        ]);

        return $pdf->download('commande-boris-lumiere-'.now()->format('Ymd-His').'.pdf');
    }
}
