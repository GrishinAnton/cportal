<?php

namespace App\Http\Controllers\Api\Report\Project;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\Project\FotResource;
use App\Http\Resources\Report\Project\HeaderResource;
use App\Repositories\Project\FotRepository;
use DB;

class FotController extends Controller
{
    /**
     * @var FotRepository
     */
    private $fotRepository;

    /**
     * TimeController constructor.
     */
    public function __construct()
    {
        $this->fotRepository = New FotRepository();
    }

    /**
     * Get fots
     *
     * @param $projectId
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show($projectId)
    {
        $fot = $this->fotRepository->project($projectId)->query()->get();

        return FotResource::collection($fot)
            ->additional([
                'header' => new HeaderResource($fot),
                'success' => true,
            ]);
    }
}
