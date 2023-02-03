<?php

namespace App\Http\Resources\Store;

use App\Http\Resources\Product\ProductNotStoreResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Generated\Store
 */
class StoreNotProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'storeName' => $this->store_name,
            'address' => $this->address,
            'timeOpen' => $this->time_open,
            'timeClose' => $this->time_close,
            'images' => $this->images,
        ];
    }
}
