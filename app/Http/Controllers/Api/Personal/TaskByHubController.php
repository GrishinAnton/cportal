<?php

namespace App\Http\Controllers\Api\Personal;

use App\Console\Commands\Api\Tasks;
use App\Http\Requests\PersonalBusyRequest;
use App\Http\Resources\Personal\PersonalBusyResource;
use App\Http\Resources\PersonalResource;
use App\Http\Controllers\Controller;
use App\Personal;
use DB;
use App\Task;
use Carbon\Carbon;

class TaskByHubController extends Controller
{
    /**
     * Index
     *
     * @param PersonalFilterRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function busy(PersonalBusyRequest $request)
    {
        $personalBusy = $this->personal($request);


        $resource = PersonalBusyResource::collection(collect($personalBusy));
        $resource->additional([
            'success' => true,
            'dates' => $this->getMonthsFromEstimate(),
        ]);

        return $resource;
    }

    /**
     * Personal query
     *
     * @return mixed
     */
    private function personal(PersonalBusyRequest $request)
    {
        $personalBusyUsers = [];
        $now = Carbon::now();
        if ($now->format('m') == $request->month) {
            $periodFrom = Carbon::now()->format('Y-m-d');
        } else {
            $periodFrom = Carbon::createFromFormat('Y-m-d', $request->year.'-'.$request->month.'-01')->format('Y-m-d');
        }
        $periodTo = Carbon::createFromFormat('Y-m', $request->year.'-'.$request->month)->endOfMonth()->format('Y-m-d');

        $personals = Personal::select(['pers_id', 'first_name', 'last_name'])
            ->where('is_active', true)
            ->with(['personalTasks' => function ($query) use ($periodFrom, $periodTo)  {
                $query->with(['times' => function ($q) use ($periodFrom, $periodTo) {
                    $q->select(['task_id', 'date', 'worktime']);
                    $q->whereBetween('date',[Carbon::parse($periodFrom), Carbon::parse($periodTo)]);
                }]);
                $query->select(['assignee_id', 'task_id','name', 'estimated_time', 'created_at', 'task_list']);
                $query->whereIn('task_list', ['In progress', 'Sprint']);
                $query->where('estimated_time','!=', 0);
                $query->where('is_completed', false);
            }])
            ->get();

            foreach ($personals as $key => $personal) {
                $taskKey = 1;
                $personalBusyTasks = [];
                if (count($personal->personalTasks) > 0) {
                    foreach ($personal->personalTasks as $task) {
                        $workTime = collect($task->times)
                            ->where('date', Carbon::now()->format('Y-m-d'))
                            ->pluck('worktime')
                            ->toArray();

                        $personalBusyTasks[$taskKey] = [
                            'task_id' => $task->task_id,
                            'name' => $task->name,
                            'task_list' => $task->task_list,
                            'estimated_time' => $task->estimated_time,
                            'worktime' => array_sum($workTime),
                            'different' => !empty($workTime) ? ($task->estimated_time - array_sum($workTime)) : $task->estimated_time - 7,
                        ];
                        $taskKey++;
                    }

                    $personalBusyUsers[$key] = [
                        'pers_id' => $personal->pers_id,
                        'first_name' => $personal->first_name,
                        'last_name' => $personal->last_name,
                        'tasks' => $personalBusyTasks,
                    ];

                }
            }

        return $personalBusyUsers;
    }

    private function getMonthsFromEstimate()
    {
        $dates = [];
        $months = [];
        $tasksThisMonth = Task::select('created_at', 'estimated_time')
        ->whereBetween('created_at', [Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])
        ->where('is_completed', false)
        ->get();

        $maxEstimate = max($tasksThisMonth->pluck('estimated_time')->toArray());
        $createdAtLongestTask = $tasksThisMonth->where('estimated_time', $maxEstimate)->first()->created_at->format('Y-m-d');
        $weeksOnLongestTask = round($maxEstimate/7/5);
        $dateCompleteLongestTask = Carbon::parse($createdAtLongestTask)->addWeeks($weeksOnLongestTask);
        $rangeDates = $this->generateDateRange(Carbon::now(), $dateCompleteLongestTask);

        foreach ($rangeDates as $key => $date) {
            $dates[Carbon::parse($date)->format('m')] = Carbon::parse($date)->format('Y');
        }

        foreach ($dates as $key => $item) {
            $months[] = [
                'month' => $key,
                'year'  => $item,
            ];
        }

        return $months;
    }


    private function generateDateRange(Carbon $start_date, Carbon $end_date)
    {
        $dates = [];
        for($date = $start_date; $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }
        return $dates;
    }
}
