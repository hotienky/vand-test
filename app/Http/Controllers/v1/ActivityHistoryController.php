<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\Contracts\ActivityServiceInterface;
use Illuminate\Http\Request;

class ActivityHistoryController extends Controller
{
    private ActivityServiceInterface $activityService;

    public function __construct(ActivityServiceInterface $activityService)
    {
        $this->activityService = $activityService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Get parameters
        $page = $request->get('page', 1);

        $pageSize = $request->get(config('page.page_size_parameter'), config('page.per_page'));
        $filter = $request->all();

        $activities = $this->activityService->getActivityLogs($filter, $page, $pageSize);

        return api_success($activities);
    }
}
