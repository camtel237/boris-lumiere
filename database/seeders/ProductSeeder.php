<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIdByName = Category::query()->pluck('id', 'name');

        $products = [
            'Câbles électriques' => [
                ['ref' => 'CAB-001', 'name' => 'Câble souple 2.5mm²', 'price' => 1200, 'image' => 'images/Electrical cable energy and technology equipment isolated on white _ Free Photo.jpg'],
                ['ref' => 'CAB-002', 'name' => 'Câble rigide 6mm²', 'price' => 2100, 'image' => 'images/Cables cables cables_.jpg'],
                ['ref' => 'CAB-003', 'name' => 'Câble réseau RJ45 (rouleau 100m)', 'price' => 28000, 'image' => 'images/299278337760071848.jpg'],
            ],
            'Appareillages électriques' => [
                ['ref' => 'APP-001', 'name' => 'Disjoncteur différentiel 32A', 'price' => 9500, 'image' => 'images/contacteur Disjoncteur DNX³ 4500 _ 4_5 kA bornes à….jpg'],
                ['ref' => 'APP-002', 'name' => 'Tableau électrique modulaire 12M', 'price' => 21000, 'image' => 'images/Digital Electric - Interrupteur Différentiel 4x80A_30mA Type AC - Réf _ 03436.jpg'],
                ['ref' => 'APP-003', 'name' => 'Interrupteur va-et-vient', 'price' => 1500, 'image' => 'images/488218415872505230.jpg'],
            ],
            'Vidéosurveillance' => [
                ['ref' => 'CAM-001', 'name' => 'Caméra dôme intérieure HD', 'price' => 18000, 'image' => 'images/laice-security-cam-infrared.jpg'],
                ['ref' => 'CAM-002', 'name' => 'Caméra IP extérieure', 'price' => 32000, 'image' => 'images/Caméra Fausse - Caméra De Surveillance Fausse À Led Clignotante - Étanche Intérieur Extérieur - Noir - 2 Pièces.jpg'],
                ['ref' => 'CAM-003', 'name' => 'Kit vidéosurveillance 4 caméras', 'price' => 145000, 'image' => 'images/1079456604507952530.jpg'],
            ],
            'Informatique & Télécom' => [
                ['ref' => 'INF-001', 'name' => 'Routeur Wifi double bande', 'price' => 24000, 'image' => 'images/Power Strip 4AC Universal Outlets Plug 2USB 2m_6_4ft Extension Cord Individual Switched Overload Protection 2500W 10A Socket - AliExpress 44.jpg'],
                ['ref' => 'INF-002', 'name' => 'Switch réseau 8 ports', 'price' => 15500, 'image' => 'images/DLink 24Port EasySmart Gigabit Ethernet Switch….jpg'],
                ['ref' => 'INF-003', 'name' => 'Téléphone IP de bureau', 'price' => 19000, 'image' => 'images/UPS IT-M1500VA Modèle_ 1500VA_900W (3 étapes de….jpg'],
            ],
        ];

        foreach ($products as $categoryName => $items) {
            $categoryId = $categoryIdByName[$categoryName] ?? null;

            if (! $categoryId) {
                continue;
            }

            foreach ($items as $item) {
                $product = Product::query()->firstOrCreate(
                    ['reference' => $item['ref']],
                    [
                        'category_id' => $categoryId,
                        'name' => $item['name'],
                        'description' => 'Produit de démonstration — à remplacer par la vraie description et la vraie photo depuis l\'espace admin.',
                        'price' => $item['price'],
                        'is_active' => true,
                        'image_path' => $item['image'] ?? null,
                    ]
                );

                if (! empty($item['image']) && $product->image_path !== $item['image']) {
                    $product->update(['image_path' => $item['image']]);
                }
            }
        }
    }
}
