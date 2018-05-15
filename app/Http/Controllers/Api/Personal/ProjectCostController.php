<?php

namespace App\Http\Controllers\Api\Personal;

use App\Http\Controllers\Controller;
use App\Http\Requests\DateRequest;
use App\Http\Requests\ProjectCostRequest;
use App\Http\Resources\ProjectCostResource;
use App\PersonalTime;
use App\ProjectCost;
use DB;

class ProjectCostController extends Controller
{
    /**
     * Project costs personal
     *
     * @param $id
     * @param DateRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($id, DateRequest $request)
    {
        $date = explode('-', $request->date);

        $personalTimes = PersonalTime::select(
            DB::raw('sum(worktime) as worktime'),
            'projects.name'
        )
            ->where('personal_times.pers_id', $id)
            ->groupBy('tasks.project_id')
            ->whereMonth('personal_times.date', $date[1])
            ->whereYear('personal_times.date', $date[0])
            ->join('tasks', function ($join) {
                $join->on('tasks.task_id', '=', 'personal_times.task_id');
            })
            ->join('projects', function ($join) {
                $join->on('projects.project_id', '=', 'tasks.project_id');
            })
            ->get();

        return ProjectCostResource::collection($personalTimes)
            ->additional(['success' => true]);
    }

    /**
     * Add project costs
     *
     * @param $persId
     * @param ProjectCostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($persId, ProjectCostRequest $request)
    {
        ProjectCost::create([
            'pers_id' => $persId,
            'project_id' => $request->projectId,
            'project_cost' => $request->projectCost,
            'hours' => $request->hours,
            'cost_override' => $request->costOverride,
            'date' => $request->date,
            'percent' => $request->percent
        ]);

        return response()->json(['success' => true]);
    }
}
