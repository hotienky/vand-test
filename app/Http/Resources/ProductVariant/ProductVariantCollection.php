<?php

namespace App\Http\Resources\ProductVariant;

use App\Http\Resources\PagingResourceCollection;

class ProductVariantCollection extends PagingResourceCollection
{
    public function toArray($request): array
    {
        return array_merge([
            'productVariants' => ProductVariantResource::collection($this->collection)
        ], $this->pagination);
    }
}
