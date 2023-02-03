<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\PagingResourceCollection;

class ProductCollection extends PagingResourceCollection
{
    public function toArray($request): array
    {
        return array_merge([
            'products' => ProductResource::collection($this->collection)
        ], $this->pagination);
    }
}
