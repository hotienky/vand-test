<?php

namespace App\Http\Resources\ActivityLog;

use App\Models\Generated\Order;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Order
 */
class ActivityLogResource extends JsonResource
{
    public function toArray($request): array
    {
        return array_merge([
            'request_id' => $this->id,
            'created_at' => $this->created_at,
            'activity_name' => $this->name,
            'user' => $this->user,
            'payload' => $this->payload
        ]);
    }
}
