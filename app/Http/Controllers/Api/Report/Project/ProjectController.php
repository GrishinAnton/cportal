<?php

namespace App\Http\Controllers\Api\Report\Project;

use App\Http\Requests\Report\Project\ProjectRequest;
use App\Http\Resources\Report\Project\ProjectResource;
use App\Http\Controllers\Controller;
use App\Project;
use Carbon\Carbon;

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

    /**
     * Upload project
     *
     * @param $projectId
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload($projectId, ProjectRequest $request)
    {
        Project::where('project_id', $projectId)
            ->update([
                'budget' => $request->budget,
                'status_id' => $request->status,
                'start_at' => Carbon::parse($request->start_at)->format('Y-m-d'),
                'finish_at' => Carbon::parse($request->finish_at)->format('Y-m-d'),
                'company_id' => $request->company,
                'cost_per_hour' => $request->costPerHour,
                ''
            ]);

        return response()->json(['success' => true]);
    }
}
