<?php

namespace App\QueryBuilder\Product;

use App\QueryBuilder\Filter;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;

class ProductName extends Filter
{
    protected function applyFilters(EloquentBuilder|QueryBuilder $builder, Collection $context): EloquentBuilder|QueryBuilder
    {
        if (empty($this->value($context))) {
            return $builder;
        }
        return $builder->where('product_name', 'LIKE', "%{$this->value($context)}%");
    }
}
