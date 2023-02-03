<?php

namespace App\Http\Resources\Store;

use App\Enums\ActiveStatus;
use App\Http\Resources\Product\ProductNotStoreResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Generated\Store
 */
class StoreResource extends JsonResource
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
            'status' => ActiveStatus::tryFrom((int) $this->status)?->label,
            'products' => ProductNotStoreResource::collection($this->products)
        ];
    }
}
