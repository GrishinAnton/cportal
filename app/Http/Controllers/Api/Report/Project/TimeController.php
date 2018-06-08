<?php

namespace App\Http\Controllers\Api\Report\Project;

use App\Http\Resources\Report\Project\HeaderResource;
use App\Http\Resources\Report\Project\HourSpentResource;
use App\Repositories\Project\TimeRepository;
use App\Http\Controllers\Controller;

class TimeController extends Controller
{
    /**
     * @var TimeRepository
     */
    private $timeRepository;

    /**
     * TimeController constructor.
     */
    public function __construct()
    {
        $this->timeRepository = New TimeRepository();
    }

    /**
     * Show
     *
     * @param $projectId
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show($projectId)
    {
        $hourSpent = $this->timeRepository
            ->project($projectId)
            ->query()
            ->get();

        return HourSpentResource::collection($hourSpent)
            ->additional([
                'header' => new HeaderResource($hourSpent),
                'success' => true,
            ]);
    }
}
