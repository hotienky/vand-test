<?php

namespace App\Http\Resources\ProductVariant;

use App\Enums\ActiveStatus;
use App\Http\Resources\Store\StoreNotProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Generated\Store
 */
class ProductVariantResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'productId' => $this->product_id,
            'images' => $this->images,
            "sku" => $this->sku,
            "name"=> $this->name,
            "stockPrice"=> $this->stock_price,
            "price"=> $this->price,
            "stock"=> $this->stock,
            "status"=>  ActiveStatus::tryFrom((int) $this->status)?->label,
            "createdAt"=> $this->created_at,
            "updatedAt"=> $this->updated_at,
        ];
    }
}
