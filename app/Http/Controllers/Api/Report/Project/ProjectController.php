<?php

namespace App\Http\Controllers\Api\Report\Project;

use App\Http\Requests\Report\Project\ProjectFilterRequest;
use App\Http\Requests\Report\Project\ProjectRequest;
use App\Http\Resources\Report\Project\ProjectResource;
use App\Http\Resources\Report\Project\SingleProjectResource;
use App\Http\Controllers\Controller;
use App\Project;
use Carbon\Carbon;

class ProjectController extends Controller
{
    /**
     * Get all projects
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ProjectFilterRequest $request)
    {
        $projects = Project::select(
            'projects.project_id',
            'projects.budget',
            'projects.name',
            'personal_companies.name as company_name',
            'project_statuses.name as status_name'
        )
            ->leftJoin('personal_companies', 'projects.company_id', '=', 'personal_companies.id')
            ->leftJoin('project_statuses', 'projects.status_id', '=', 'project_statuses.id');

        foreach ($request->all() as $key => $filter) {
            try {
                $projects->{$key}($filter);
            } catch (\Exception $e) {
                report($e);
            }
        }

        return ProjectResource::collection($projects->paginate(75))
            ->additional(['success' => true]);
    }

    /**
     * Show info project
     *
     * @param $projectId
     * @return SingleProjectResource
     */
    public function show($projectId)
    {
        $project = Project::select(
            'name',
            'budget',
            'start_at',
            'finish_at',
            'company_id',
            'status_id',
            'hours_laid',
            'cost_per_hour'
        )
            ->where('project_id', $projectId)
            ->first();

        if (! $project) {
            return response()->json(['success' => false]);
        }

        return (new SingleProjectResource($project))
            ->additional(['success' => true]);
    }

    /**
     * Upload project
     *
     * @param $projectId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($projectId, ProjectRequest $request)
    {
        Project::where('project_id', $projectId)
            ->update([
                'budget' => $request->budget,
                'status_id' => $request->status,
                'start_at' => Carbon::parse($request->start_at)->format('Y-m-d'),
                'finish_at' => Carbon::parse($request->finish_at)->format('Y-m-d'),
                'company_id' => $request->company,
                'cost_per_hour' => $request->cost_per_hour,
                'hours_laid' => $request->hours_laid,
            ]);

        return response()->json(['success' => true]);
    }
}
