<?php

namespace App\Services;

use App\Http\Resources\ActivityLog\ActivityLogCollection;
use App\Repositories\Contracts\ActivityRepoInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ActivityService implements Contracts\ActivityServiceInterface
{
    protected ActivityRepoInterface $activityRepo;
    public function __construct(
        ActivityRepoInterface $activityRepo,
    ) {
        $this->activityRepo = $activityRepo;
    }
    public function log($name,int $user_id, $product, $product_old)
    {

        $this->activityRepo->create([
            'request_id' => Str::uuid()->toString(),
            'name' => $name,
            'payload' => [
                'before' => $product_old,
                'after' => $product
            ],
            'user_id' => $user_id,
            'created_at' => Carbon::now(),
        ]);
    }
    public function getActivityLogs($filter, $page, $pageSize)
    {
        $pageSize = $pageSize ?? config('page.max_per_page');
        $page = $page ?? 1;

        $paginateActivities = $this->activityRepo->paginateWithFilter($filter, $pageSize, ['*'], $page = $page);

        return ActivityLogCollection::make($paginateActivities)->toArray($filter);
    }
}
