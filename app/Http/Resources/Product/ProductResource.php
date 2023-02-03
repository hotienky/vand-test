<?php

namespace App\Http\Resources\Product;

use App\Enums\ActiveStatus;
use App\Http\Resources\ProductVariant\ProductVariantResource;
use App\Http\Resources\Store\StoreNotProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Generated\Store
 */
class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'productName' => $this->product_name,
            'images' => $this->images,
            "description"=> $this->description,
            "status"=> ActiveStatus::tryFrom((int) $this->status)?->label,
            "createdAt"=> $this->created_at,
            "updatedAt"=> $this->updated_at,
            'stores' => StoreNotProductResource::collection($this->stores),
            "productVariants" => ProductVariantResource::collection($this->product_variants),
        ];
    }
}
