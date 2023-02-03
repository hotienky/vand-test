<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\ProductVariant\ProductVariantResource;
use App\Http\Resources\Store\StoreResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Generated\Store
 */
class ProductNotStoreResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'productName' => $this->product_name,
            'images' => $this->images,
            "description"=> $this->description,
            "status"=> $this->status,
            "createdAt"=> $this->created_at,
            "updatedAt"=> $this->updated_at,
            "productVariants" => ProductVariantResource::collection($this->product_variants),
        ];
    }
}
