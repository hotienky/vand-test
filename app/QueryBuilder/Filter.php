<?php

namespace App\QueryBuilder;

use Closure;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class Filter
{
    public function handle(EloquentBuilder|QueryBuilder $builder, Collection $context,  Closure $next): EloquentBuilder|QueryBuilder
    {
        if (!$context->has($this->filterName())) {
            return $next($builder);
        }

        $builder = $next($builder);

        return $this->applyFilters($builder, $context);
    }

    protected abstract function applyFilters(EloquentBuilder|QueryBuilder $builder, Collection $context): EloquentBuilder|QueryBuilder;

    protected function filterName(): string
    {
        return Str::snake(class_basename($this));
    }

    protected function value(Collection $context, $default = null): string|array|null
    {
        return $context->get($this->filterName(), $default);
    }
}
