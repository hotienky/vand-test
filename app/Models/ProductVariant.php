<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "product_id",
        "sku",
        "name",
        "stock_price",
        "price",
        "stock",
        "status",
        "images",
        "created_at",
        "updated_at",
    ];

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }

    public function getImagesAttribute($value)
    {
        return $value ? json_decode($value) : null;
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
