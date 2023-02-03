<?php

namespace App\QueryBuilder\Store;

use App\QueryBuilder\Filter;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;

class StoreName extends Filter
{
    protected function applyFilters(EloquentBuilder|QueryBuilder $builder, Collection $context): EloquentBuilder|QueryBuilder
    {
        if (empty($this->value($context))) {
            return $builder;
        }
        return $builder->where('store_name', 'LIKE', "%{$this->value($context)}%");
    }
}
