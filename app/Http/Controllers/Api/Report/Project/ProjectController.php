<?php

namespace App\Http\Controllers\Api\Report\Project;

use App\Http\Resources\Report\Project\ProjectResource;
use App\Http\Controllers\Controller;
use App\Project;

class ProjectController extends Controller
{
    /**
     * Show info project
     *
     * @param $projectId
     * @return ProjectResource
     */
    public function show($projectId)
    {
        $project = Project::select('name', 'budget')
            ->where('project_id', $projectId)
            ->first();

        if (! $project) {
            return response()->json(['success' => false]);
        }

        return (new ProjectResource($project))
            ->additional(['success' => true]);
    }
}
