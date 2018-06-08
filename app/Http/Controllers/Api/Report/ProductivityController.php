<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonalFilterRequest;
use App\Http\Resources\Report\ProductivityResource;
use App\Personal;
use Carbon\Carbon;
use DB;

class ProductivityController extends Controller
{
    /**
     * Productivity
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(PersonalFilterRequest $request)
    {
        $personal = $this->queryProductivity();

        foreach ($request->all() as $key => $filter) {
            try {
                $personal->{$key}($filter);
            } catch (\Exception $e) {
                report($e);
            }
        }

        return ProductivityResource::collection($personal->paginate(75))
            ->additional(['success' => true]);
    }

    /**
     * Query productivity
     *
     * @return mixed
     */
    private function queryProductivity()
    {
        $personal = Personal::select(
            'personal.id',
            'personal.first_name',
            'personal.last_name',
            'personal.pers_id',
            DB::raw('sum(t3.week1) as week1'),
            DB::raw('sum(t3.week2) as week2'),
            DB::raw('sum(t3.week3) as week3'),
            DB::raw('sum(t3.week4) as week4'),
            DB::raw('sum(t3.week5) as week5'),
            DB::raw('sum(t3.week6) as week6')
        )
            ->leftJoin(DB::raw("(
                SELECT
                    pers_id,
                    IF(weeks = 1, sum, null) as week1,
                    IF(weeks = 2, sum, null) as week2,
                    IF(weeks = 3, sum, null) as week3,
                    IF(weeks = 4, sum, null) as week4,
                    IF(weeks = 5, sum, null) as week5,
                    IF(weeks = 6, sum, null) as week6
                FROM (
                    SELECT
                        sum(worktime) as sum,
                        pers_id,
                        weeks
                    FROM (
                        SELECT
                            IF(date BETWEEN '{$this->getStartOfWeekDate('-6 week')}' AND '{$this->getEndOfWeekDate('-6 week')}', 1,
                                IF(date BETWEEN '{$this->getStartOfWeekDate('-5 week')}' AND '{$this->getEndOfWeekDate('-5 week')}', 2,
                                    IF(date BETWEEN '{$this->getStartOfWeekDate('-4 week')}' AND '{$this->getEndOfWeekDate('-4 week')}', 3,
                                        IF(date BETWEEN '{$this->getStartOfWeekDate('-3 week')}' AND '{$this->getEndOfWeekDate('-3 week')}', 4,
                                            IF(date BETWEEN '{$this->getStartOfWeekDate('-2 week')}' AND '{$this->getEndOfWeekDate('-2 week')}', 5,
                                                IF(date BETWEEN '{$this->getStartOfWeekDate('-1 week')}' AND '{$this->getEndOfWeekDate('-1 week')}', 6, null)
                                            )
                                        )
                                    )
                                )
                            ) as weeks,
                            pers_id,
                            worktime
                        FROM personal_times
                    ) as pt
                    WHERE weeks IS NOT NULL
                    GROUP BY pt.weeks, pt.pers_id
                ) as t2 ) as t3"), 't3.pers_id', '=', 'personal.pers_id')
            ->groupBy('personal.id')
            ->where('is_active', true);

        return $personal;
    }

    /**
     * Get start of week date
     *
     * @param $modify
     * @return string
     */
    private function getStartOfWeekDate($modify)
    {
        return Carbon::now()->modify($modify)->startOfWeek()->format('Y-m-d');
    }

    /**
     * Get end if week date
     *
     * @param $modify
     * @return string
     */
    private function getEndOfWeekDate($modify)
    {
        return Carbon::now()->modify($modify)->endOfWeek()->format('Y-m-d');
    }
}



select 
    `personal`.`pers_id`,
    `personal`.`first_name`,
    `personal`.`last_name`,
    `2018-2`,
    `2018-3`,
    `2018-4`,
    `2018-5`,
    `2018-6` 
from `personal` 
right join (
    SELECT 
    	sum(`2018-2`) as `2018-2`,
    	sum(`2018-3`) as `2018-3`,
    	sum(`2018-4`) as `2018-4`,
    	sum(`2018-5`) as `2018-5`,
    	sum(`2018-6`) as `2018-6`,
    	pers_id
    FROM (
        SELECT
        	IF(yearmonth = '2018-2', worktime, null) as `2018-2`,
        	IF(yearmonth = '2018-3', worktime, null) as `2018-3`,
        	IF(yearmonth = '2018-4', worktime, null) as `2018-4`,
        	IF(yearmonth = '2018-5', worktime, null) as `2018-5`,
        	IF(yearmonth = '2018-6', worktime, null) as `2018-6`,
        	pers_id,
            task_id
        FROM (
            SELECT
            	CONCAT(YEAR(date), '-', MONTH(date)) as yearmonth,
            	pers_id,
            	worktime,
            	task_id
            FROM personal_times
                WHERE task_id IN (
                    SELECT task_id FROM tasks WHERE project_id = 51
                )
        	) as t2
    	) as t3
    GROUP BY t3.pers_id
) as t4 on `t4`.`pers_id` = `personal`.`pers_id`
right join (
    SELECT 
        sum(`2018-2`) as `z-2018-2`,
        sum(`2018-3`) as `z-2018-3`,
        sum(`2018-4`) as `z-2018-4`,
        sum(`2018-5`) as `z-2018-5`,
        sum(`2018-6`) as `z-2018-6`,
        pers_id
    FROM (
        SELECT
        	IF(yearmonth = '2018-2', worktime, null) as `z-2018-2`,
        	IF(yearmonth = '2018-3', worktime, null) as `z-2018-3`,
        	IF(yearmonth = '2018-4', worktime, null) as `z-2018-4`,
        	IF(yearmonth = '2018-5', worktime, null) as `z-2018-5`,
        	IF(yearmonth = '2018-6', worktime, null) as `z-2018-6`,
        	pers_id
        FROM (
                SELECT
                    CONCAT(YEAR(date), '-', MONTH(date)) as yearmonth,
                    pers_id,
                    salary
                FROM salaries
        	) as t2
    	) as t3
    GROUP BY t3.pers_id
) as t5 on `t5`.`pers_id` = `personal`.`pers_id`      
