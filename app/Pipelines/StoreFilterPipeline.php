<?php


namespace App\Pipelines;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class StoreFilterPipeline extends AbstractFilterPipeline
{
    protected $pipes = [
        \App\QueryBuilder\Store\StoreName::class,
        \App\QueryBuilder\Store\Address::class,
    ];

    public static function run(EloquentBuilder|QueryBuilder $builder, array $context): EloquentBuilder|QueryBuilder
    {
        return app(static::class)->with($context)->send($builder)->thenReturn();
    }
}
