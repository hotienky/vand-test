<?php

namespace App\QueryBuilder;

use App\Constants\SortDirection;
use Closure;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class Sort
{
    public function handle(EloquentBuilder|QueryBuilder $builder, Collection $context, Closure $next): EloquentBuilder|QueryBuilder
    {
        // if (!$context->has($this->sortName())) {
        //     return $next($builder);
        // }

        $builder = $next($builder);

        return $this->applySorts($builder, $context);
    }

    public function applySorts(EloquentBuilder|QueryBuilder $builder, Collection $context): EloquentBuilder|QueryBuilder
    {
        return $builder;
    }

    protected function sortName(): string
    {
        return Str::snake(class_basename($this));
    }

    protected function value(Collection $context, $default = null): array|string|null
    {
        return $context->get($this->sortName(), $default);
    }

    protected function sortDirection(Collection $context): string
    {
        if ($context->get('sort_type', SortDirection::DESCENDING) === SortDirection::ASCENDING) {
            return SortDirection::ASCENDING;
        }

        return SortDirection::DESCENDING;
    }
}
