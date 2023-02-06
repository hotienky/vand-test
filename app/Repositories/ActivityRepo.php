<?php

namespace App\Repositories;

use App\Models\ActivityHistory;
use App\Pipelines\ActivityHistoryFilterPipeline;

/**
 * Class ActivityRepo.
 */
class ActivityRepo extends BaseEloquentRepository implements Contracts\ActivityRepoInterface
{
    public function __construct(ActivityHistory $model)
    {
        parent::__construct($model);
    }
    public function paginateWithFilter($filter, $perPage = 15, $columns = ['*'], $page = null)
    {
        $activities = ActivityHistoryFilterPipeline::run(
            ActivityHistory::query(),
            $filter
        );
        return $activities->paginate($perPage, $columns, 'page', $page ?? 1);
    }
}
