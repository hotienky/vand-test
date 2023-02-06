<?php

namespace App\Services\Contracts;

interface ActivityServiceInterface
{
    public function log(string $name,int  $user_id, $product,  $product_old);
    public function getActivityLogs(array $filter, int|null $page, int|null $pageSize);
}
