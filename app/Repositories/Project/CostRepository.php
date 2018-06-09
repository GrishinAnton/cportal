<?php

namespace App\Repositories\Project;

use App\Personal;
use DB;

class CostRepository extends ProjectRepository
{
    /**
     * Query costs
     *
     * @return mixed
     */
    public function query()
    {
        $personal = Personal::select($this->getFotSelect())
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
            ) as t4"), 't4.pers_id', '=', 'personal.pers_id')
            ->leftJoin(DB::raw("(
                SELECT "
                . $this->getT3Select('z') .
                "pers_id
                FROM (
                    SELECT "
                . $this->getT2Select('z') .
                "pers_id,
                    task_id
                    FROM (
                        SELECT
            	            CONCAT(YEAR(date), '-', MONTH(date)) as yearmonth,
            	            pers_id,
            	            worktime,
            	            task_id
                        FROM personal_times
                    ) as t2
                ) as t3
                GROUP BY t3.pers_id
            ) as t5"), 't5.pers_id', '=', 'personal.pers_id')
            ->join(DB::raw("(
                SELECT "
                .  substr($this->getT3Select('s'), 0, -2) .
                " FROM (
                    SELECT "
                . substr($this->getT2Select('s', 'cost') , 0, -2) .
                " FROM (
                        SELECT
            	            CONCAT(YEAR(date), '-', MONTH(date)) as yearmonth,
            	            cost
                        FROM costs
                    ) as t2
                ) as t3
            ) as t6"), 'personal.pers_id', '=', 'personal.pers_id');

        return $personal;
    }
}