<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'reference',
        'name',
        'slug',
        'description',
        'price',
        'image_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Product $product): void {
            if (blank($product->slug)) {
                $product->slug = Str::slug($product->name).'-'.Str::random(5);
            }
        });
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Public URL of the product image, falling back to a placeholder.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->image_path) {
                if (Str::startsWith($this->image_path, 'images/')) {
                    return asset($this->image_path);
                }

                return route('media', ['path' => $this->image_path]);
            }

            return asset('images/placeholder-product.svg');
        });
    }

    /**
    * Human readable price, e.g. "1 200 FCFA".
     */
    protected function formattedPrice(): Attribute
    {
        return Attribute::get(
            fn () => number_format((float) $this->price, 0, ',', ' ').' FCFA'
        );
    }
}
