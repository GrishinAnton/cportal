<?php

namespace App\Http\Controllers\Api\Report\Free;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\Free\PersonalResource;
use App\PersonalTime;
use DB;

class FreeController extends Controller
{
    public function personal()
    {
        $personal = PersonalTime::select(
            DB::raw('sum(worktime) as worktime'),
            'projects.name',
            'projects.project_id'
        )
            ->groupBy('tasks.project_id')
            ->whereYear('personal_times.date', 2018)
            ->join('tasks', function ($join) {
                $join->on('tasks.task_id', '=', 'personal_times.task_id');
            })
            ->join('projects', function ($join) {
                $join->on('projects.project_id', '=', 'tasks.project_id');
            })
            ->get();

        dd($personal);

        return PersonalResource::collection($personal)
            ->additional(['success' => true]);
    }
}
