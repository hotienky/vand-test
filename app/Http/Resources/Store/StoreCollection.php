<?php

namespace App\Http\Resources\Store;

use App\Http\Resources\PagingResourceCollection;

class StoreCollection extends PagingResourceCollection
{
    public function toArray($request): array
    {
        return array_merge([
            'stores' => StoreResource::collection($this->collection)
        ], $this->pagination);
    }
}
