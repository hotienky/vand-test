<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class PagingResourceCollection extends ResourceCollection
{
    protected array $pagination = [];

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->pagination = [
            'page' => $resource->currentPage(),
            'page_size' => intval($resource->perPage()),
            'next_page' => $resource->hasMorePages() ? $resource->currentPage() + 1 : null,
            'previous_page' => ($resource->currentPage() - 1 > 0) ? $resource->currentPage() - 1 : null,
            'total_page' => $resource->lastPage(),
            'total_records' => $resource->total(),
        ];
    }

    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);
        unset($jsonResponse['links'], $jsonResponse['meta']);
        $response->setContent(json_encode($jsonResponse));
    }
}
