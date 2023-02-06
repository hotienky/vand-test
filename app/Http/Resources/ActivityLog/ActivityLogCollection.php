<?php

namespace App\Http\Resources\ActivityLog;

use App\Http\Resources\ActivityLog\ActivityLogResource;
use App\Http\Resources\PagingResourceCollection;

class ActivityLogCollection extends PagingResourceCollection
{
    public function toArray($request): array
    {
        return array_merge([
            'activities' => ActivityLogResource::collection($this->collection)
        ], $this->pagination);
    }
}
