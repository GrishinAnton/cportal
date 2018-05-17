<?php

namespace App\Http\Controllers\Api\Personal;

use App\Http\Controllers\Controller;
use App\Http\Requests\DateRequest;
use App\Http\Requests\ProjectCostRequest;
use App\Http\Resources\PersonalTimeResource;
use App\Http\Resources\ProjectCostResource;
use App\PersonalTime;
use App\ProjectCost;
use DB;

class ProjectCostController extends Controller
{
    /**
     * Date year
     */
    private const DATE_YEAR = 0;

    /**
     * Date month
     */
    private const DATE_MONTH = 1;

    /**
     * Project costs personal
     *
     * @param $persId
     * @param DateRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($persId, DateRequest $request)
    {
        $date = explode('-', $request->date);

        $projectCosts = $this->getProjectCost($persId, $date);

        if ($projectCosts->isNotEmpty()) {
            return ProjectCostResource::collection($projectCosts)
                ->additional([
                    'success' => true,
                    'costProject' => true,
                ]);
        }

        $personalTimes = $this->getPersonalTime($persId, $date);

        return PersonalTimeResource::collection($personalTimes)
            ->additional([
                'success' => true,
                'costProject' => false,
            ]);
    }

    /**
     * Get project costs
     *
     * @param $persId
     * @param $date
     * @return mixed
     */
    private function getProjectCost($persId, $date)
    {
        return ProjectCost::select('hours', 'project_id', 'percent', 'cost_override', 'project_cost')
            ->whereYear('date', $date[self::DATE_YEAR])
            ->whereMonth('date', $date[self::DATE_MONTH])
            ->with('projects')
            ->where('pers_id', $persId)
            ->get();
    }

    /**
     * Get personal time
     *
     * @param $id
     * @param $date
     * @return mixed
     */
    private function getPersonalTime($id, $date)
    {
        return PersonalTime::select(
            DB::raw('sum(worktime) as worktime'),
            'projects.name',
            'projects.project_id'
        )
            ->where('personal_times.pers_id', $id)
            ->groupBy('tasks.project_id')
            ->whereMonth('personal_times.date', $date[self::DATE_MONTH])
            ->whereYear('personal_times.date', $date[self::DATE_YEAR])
            ->join('tasks', function ($join) {
                $join->on('tasks.task_id', '=', 'personal_times.task_id');
            })
            ->join('projects', function ($join) {
                $join->on('projects.project_id', '=', 'tasks.project_id');
            })
            ->get();
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
