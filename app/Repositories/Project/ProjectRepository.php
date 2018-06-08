<?php

namespace App\Repositories\Project;

use App\Repositories\Repository;
use Carbon\Carbon;
use App\Task;
use DB;

class ProjectRepository extends Repository
{
    /**
     * @var array
     */
    private $personalInfo = [
        'personal.pers_id',
        'personal.first_name',
        'personal.last_name',
    ];

    /**
     * @var array
     */
    protected $dates;

    /**
     * @var integer
     */
    protected $projectId;

    /**
     * Set Project Id
     *
     * @param $projectId
     * @return $this
     */
    public function project($projectId)
    {
        $this->projectId = $projectId;

        $this->dates = $this->dates();

        return $this;
    }

    /**
     * Dates array
     *
     * @return $this
     */
    private function dates()
    {
        $betweenDate = $this->betweenDate();

        $min = Carbon::parse($betweenDate->min);
        $max = Carbon::parse($betweenDate->max);

        $dates[$min->format('Y-n')] = $min->format('Y-n');
        $date = $min->format('Y-n');

        while ($max->format('Y-n') != $date) {
            $date = $min->modify('+1 month')->format('Y-n');
            $dates[$min->format('Y-n')] = $date;
        }

        return $dates;
    }

    /**
     * Get beetwen date
     *
     * @return mixed
     */
    private function betweenDate()
    {
        $tasks = Task::selectRaw('min(personal_times.date) as min, max(personal_times.date) as max')
            ->where('tasks.project_id', $this->projectId)
            ->join('personal_times', 'tasks.task_id' , '=', 'personal_times.task_id')
            ->first();

        return $tasks;
    }

    /**
     * Get t3 select
     *
     * @param null $prefix
     * @return string
     */
    protected function getT3Select($prefix = null)
    {
        $t3Select = '';

        foreach ($this->dates as $key => $date) {
            if (! empty($prefix)) {
                $t3Select .= "sum(`{$prefix}-{$key}`) as `{$prefix}-{$key}`, ";
            } else {
                $t3Select .= "sum(`{$key}`) as `{$key}`, ";
            }
        }

        return $t3Select;
    }

    /**
     * get t2 select
     *
     * @param null $prefix
     * @return string
     */
    protected function getT2Select($prefix = null, $field = 'worktime')
    {
        $t2Select = '';

        foreach ($this->dates as $key => $date) {
            if (! empty($prefix)) {
                $t2Select .= "IF(yearmonth = '{$date}', {$field}, null) as `{$prefix}-{$key}`, ";
            } else {
                $t2Select .= "IF(yearmonth = '{$date}', {$field}, null) as `{$key}`, ";
            }
        }

        return $t2Select;
    }

    /**
     * Get time select
     *
     * @return array
     */
    protected function getTimeSelect()
    {
        foreach ($this->dates as $key => $date) {
            $this->personalInfo[] = $key;
        }

        return $this->personalInfo;
    }

    /**
     * Get fot select
     *
     * @return array
     */
    protected function getFotSelect()
    {
        foreach ($this->dates as $key => $date) {
            $this->personalInfo[] = DB::raw("(`s-{$key}` * (`{$key}` / `z-{$key}`)) as `{$key}`");
        }

        return $this->personalInfo;
    }
}