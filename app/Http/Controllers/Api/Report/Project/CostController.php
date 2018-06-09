<?php

namespace App\Http\Controllers\Api\Report\Project;

use App\Http\Resources\Report\Project\CostResource;
use App\Http\Resources\Report\Project\HeaderResource;
use App\Repositories\Project\CostRepository;
use App\Http\Controllers\Controller;

class CostController extends Controller
{
    /**
     * @var CostRepository
     */
    private $costRepository;

    /**
     * CostController constructor.
     */
    public function __construct()
    {
        $this->costRepository = new CostRepository();
    }

    /**
     * Get costs
     *
     * @param $projectId
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show($projectId)
    {
        $costs = $this->costRepository->project($projectId)->query()->get();

        return CostResource::collection($costs)->additional([
            'header' => new HeaderResource($costs),
            'success' => true,
        ]);
    }
}
