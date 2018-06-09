<?php

namespace App\Http\Controllers\Api\Report\Project;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\Project\StatusResource;
use App\ProjectStatus;

class StatusController extends Controller
{
    /**
     * Get all statuses
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $projectStatuses = ProjectStatus::select('id', 'name')->get();

        return StatusResource::collection($projectStatuses)
            ->additional(['success' => true]);
    }
}
