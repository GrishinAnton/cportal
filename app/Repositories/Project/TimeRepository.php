<?php

namespace App\Repositories\Project;

use App\Personal;
use DB;

class TimeRepository extends ProjectRepository
{
    /**
     * Query
     *
     * @return mixed
     */
    public function query()
    {
        $personal = Personal::select($this->getTimeSelect())
            ->rightJoin(DB::raw("(
                SELECT "
                . $this->getT3Select() .
                "pers_id
                FROM (
                    SELECT "
                . $this->getT2Select() .
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
                            SELECT task_id FROM tasks WHERE project_id = {$this->projectId}
                        ) 
                    ) as t2
                ) as t3
                GROUP BY t3.pers_id
            ) as t4"), 't4.pers_id', '=', 'personal.pers_id');

        return $personal;
    }
}