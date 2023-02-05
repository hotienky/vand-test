<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "user_id",
        "store_name",
        "images",
        "address",
        "status",
        "time_open",
        "time_close",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'store_product');
    }

    public function user()
    {
        return $this->belongsTo(Product::class);
    }
}
