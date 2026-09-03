<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #14202F; font-size: 12px; }
        .header { display: flex; justify-content: space-between; border-bottom: 3px solid #E8720C; padding-bottom: 12px; margin-bottom: 20px; }
        .brand { font-size: 20px; font-weight: bold; color: #0B1F3A; }
        .slogan { font-size: 11px; color: #5A6B80; }
        .meta { text-align: right; font-size: 11px; color: #5A6B80; line-height: 1.5; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { text-align: left; background: #F7F5F0; padding: 8px; font-size: 11px; text-transform: uppercase; }
        td { padding: 8px; border-bottom: 1px solid #E3E0D8; font-size: 12px; }
        .num { text-align: right; }
        .total { text-align: right; font-size: 15px; font-weight: bold; color: #0B1F3A; margin-top: 14px; }
        .footer { margin-top: 24px; font-size: 10px; color: #5A6B80; border-top: 1px solid #E3E0D8; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="brand">⚡ Boris Lumière</div>
            <div class="slogan">La qualité supérieure au meilleur prix</div>
        </div>
        <div class="meta">
            Récapitulatif de commande<br>
            Date : {{ $date }}<br>
            En face Enéo Ndokoti, derrière la SGBC banque, Douala<br>
            (+237) 680 65 97 24 · 691 83 36 78<br>
            ngouanetboris@gmail.com
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Réf.</th>
                <th>Produit</th>
                <th class="num">Prix unitaire</th>
                <th class="num">Qté</th>
                <th class="num">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                @php($product = $item['product'])
                <tr>
                    <td>{{ $product->reference ?? '—' }}</td>
                    <td>{{ $product->name }}</td>
                    <td class="num">{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                    <td class="num">{{ $item['quantity'] }}</td>
                    <td class="num">{{ number_format($item['subtotal'], 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">Total indicatif : {{ number_format($total, 0, ',', ' ') }} FCFA</div>

    <div class="footer">
        Prix indicatifs — le prix final, le mode de paiement et la livraison sont confirmés directement
        sur WhatsApp avec Boris Lumière.<br>
        Merci de joindre ce document en pièce jointe de votre message WhatsApp pour finaliser la commande.
    </div>
</body>
</html>
