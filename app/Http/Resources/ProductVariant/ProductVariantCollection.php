<?php

namespace App\Http\Resources\ProductVariant;

use App\Http\Resources\PagingResourceCollection;
use App\Http\Resources\Product\ProductResource;

class ProductVariantCollection extends PagingResourceCollection
{
    public function toArray($request): array
    {
        return array_merge([
            'products' => ProductResource::collection($this->collection)
        ], $this->pagination);
    }
}
