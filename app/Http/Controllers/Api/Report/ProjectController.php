<?php

namespace App\Http\Controllers\Api\Report;

use App\Personal;
use DB;
use App\Http\Controllers\Controller;
use App\Task;
use Carbon\Carbon;

class ProjectController extends Controller
{
    public function show($projectId)
    {
        $tasks = Task::selectRaw('min(personal_times.date) as min, max(personal_times.date) as max')
            ->where('tasks.project_id', $projectId)
            ->join('personal_times', 'tasks.task_id' , '=', 'personal_times.task_id')
            ->first();

        $dates = $this->datesArray($tasks->min, $tasks->max);

        dd($this->queryProjects($dates, $projectId)->get());

    }

    /**
     * Dates array
     *
     * @param $min
     * @param $max
     * @return array
     */
    private function datesArray($min, $max)
    {
        $min = Carbon::parse($min);
        $max = Carbon::parse($max);

        $dates['date1'] = $min->format('Y-n');
        $date = $min->format('Y-n');

        $i = 2;

        while ($max->format('Y-n') != $date) {
            $date = $min->modify('+1 month')->format('Y-n');
            $dates['date' . $i] = $date;

            $i++;
        }

        return $dates;
    }

    /**
     * Get t3 select
     *
     * @param $dates
     * @return string
     */
    private function getT3Select($dates)
    {
        $t3Select = '';

        foreach ($dates as $key => $date) {
            $t3Select .= "sum({$key}) as {$key}, ";
        }

        return $t3Select;
    }

    /**
     * Get t2 select
     *
     * @param $dates
     * @return string
     */
    private function getT2Select($dates)
    {
        $t2Select = '';

        foreach ($dates as $key => $date) {
            $t2Select .= "IF(yearmonth = '{$date}', worktime, null) as {$key}, ";
        }

        return $t2Select;
    }

    /**
     * Get general select
     *
     * @param $dates
     * @return array
     */
    private function getGeneralSelect($dates)
    {
        $generalSelect = [
            'personal.id',
            'personal.first_name',
            'personal.last_name',
        ];

        foreach ($dates as $key => $date) {
            $generalSelect[] = $key;
        }

        return $generalSelect;
    }

    /**
     * Query Projects
     *
     * @param $dates
     * @param $projectId
     * @return mixed
     */
    private function queryProjects($dates, $projectId)
    {
        $personal = Personal::select($this->getGeneralSelect($dates))
        ->rightJoin(DB::raw("(
            SELECT "
            . $this->getT3Select($dates) .
                "pers_id
            FROM (
                SELECT "
                . $this->getT2Select($dates) .
                    "pers_id,
                    task_id
                FROM (
                    SELECT
                        CONCAT(YEAR(date), '-', MONTH(date)) as yearmonth,
                        pers_id,
                        worktime,
                        task_id
                    FROM personal_times
                    WHERE task_id IN (
                        SELECT task_id FROM tasks WHERE project_id = {$projectId}
                    ) 
                ) as t2
            ) as t3
            GROUP BY t3.pers_id
        ) as t4"), 't4.pers_id', '=', 'personal.pers_id');

        return $personal;
    }
}
