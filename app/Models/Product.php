<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "user_id",
        "slug",
        "product_name",
        "description",
        "images",
        "status",
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

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_product');
    }

    public function product_variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
