<?php

namespace App\Repositories\Contracts;

interface ActivityRepoInterface
{
    public function create($model);
    public function paginateWithFilter($filter, $perPage = 15, $columns = ['*'], $page = null);
}
