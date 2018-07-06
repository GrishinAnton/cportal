<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use DB;
use App\Personal;
use Carbon\Carbon;

class WidgetController extends Controller
{
    public function index()
    {
        dump($this->getDate());

        //dump($this->getEndOfWeekDate());

        $personal = Personal::select(
            'personal.first_name',
            'personal.last_name',
            'personal.pers_id',
            DB::raw('sum(t3.week1) as week1'),
            DB::raw('sum(t3.week2) as week2'),
            DB::raw('sum(t5.mon) as mon'),
            DB::raw('sum(t5.tue) as tue'),
            DB::raw('sum(t5.wed) as wed'),
            DB::raw('sum(t5.thu) as thu'),
            DB::raw('sum(t5.fri) as fri'),
            DB::raw('sum(t5.sat) as sat'),
            DB::raw('sum(t5.sun) as sun')
        )
            ->leftJoin(DB::raw("(
                SELECT
                    pers_id,
                    IF(days = 1, worktime, null) as mon,
                    IF(days = 2, worktime, null) as tue,
                    IF(days = 3, worktime, null) as wed,
                    IF(days = 4, worktime, null) as thu,
                    IF(days = 5, worktime, null) as fri,
                    IF(days = 6, worktime, null) as sat,
                    IF(days = 7, worktime, null) as sun
                FROM (
                    SELECT
                        sum(worktime) as worktime,
                        pers_id,
                        days
                    FROM (
                        SELECT
                            IF(DATE(date) = '{$this->getDate()}', 1,
                                IF(DATE(date) = '{$this->getDate('+1 day')}', 2,
                                    IF(DATE(date) = '{$this->getDate('+2 day')}', 3,
                                        IF(DATE(date) = '{$this->getDate('+3 day')}', 4,
                                            IF(DATE(date) = '{$this->getDate('+4 day')}', 5,
                                                IF(DATE(date) = '{$this->getDate('+5 day')}', 6,
                                                    IF(DATE(date) = '{$this->getDate('+6 day')}', 7, null)
                                                )
                                            )
                                        )
                                    )
                                )
                            ) as days,
                            pers_id,
                            worktime
                        FROM personal_times
                    ) as t1
                    GROUP BY t1.pers_id, t1.days
                ) as t4) as t5"), 't5.pers_id', '=', 'personal.pers_id')
            ->leftJoin(DB::raw("(
                SELECT
                    pers_id,
                    IF(weeks = 1, sum, null) as week1,
                    IF(weeks = 2, sum, null) as week2
                FROM (
                    SELECT
                        sum(worktime) as sum,
                        pers_id,
                        weeks
                    FROM (
                        SELECT
                            IF(date BETWEEN '{$this->getStartOfWeekDate('-1 week')}' AND '{$this->getEndOfWeekDate('-1 week')}', 1,
                                IF(date BETWEEN '{$this->getStartOfWeekDate()}' AND '{$this->getEndOfWeekDate()}', 2, null)
                            ) as weeks,
                            pers_id,
                            worktime
                        FROM personal_times
                    ) as pt
                    WHERE weeks IS NOT NULL
                    GROUP BY pt.weeks, pt.pers_id
                ) as t2 ) as t3"), 't3.pers_id', '=', 'personal.pers_id')
            ->groupBy('personal.pers_id')
            ->where('is_active', true)
            ->where('t3.pers_id', 39);

        dd($personal->toSql());

        return response()->json($personal);
    }

    /**
     * Get start of week date
     *
     * @param $modify
     * @return string
     */
    private function getStartOfWeekDate($modify = null, $format = 'Y-m-d')
    {
        if (is_null($modify)) {
            return Carbon::now()->startOfWeek()->format($format);
        }

        return Carbon::now()->modify($modify)->startOfWeek()->format($format);
    }

    /**
     * Get end if week date
     *
     * @param $modify
     * @return string
     */
    private function getEndOfWeekDate($modify = null, $format = 'Y-m-d')
    {
        if (is_null($modify)) {
            return Carbon::now()->endOfWeek()->format($format);
        }

        return Carbon::now()->modify($modify)->endOfWeek()->format($format);
    }

    /**
     * Get date
     *
     * @param null $modify
     * @param string $format
     * @return string
     */
    private function getDate($modify = null, $format = 'Y-m-d')
    {
        if (is_null($modify)) {
            return Carbon::now()->startOfWeek()->format($format);
        }

        $date = Carbon::now()->startOfWeek();

        return $date->modify($modify)->format($format);
    }
}



select
	`personal`.`first_name`,
   	`personal`.`last_name`,
    `personal`.`pers_id`,
    sum(t3.week1) as week1,
    sum(t3.week2) as week2,
    sum(t5.mon) as mon,
    sum(t5.tue) as tue,
    sum(t5.wed) as wed,
    sum(t5.thu) as thu,
    sum(t5.fri) as fri,
    sum(t5.sat) as sat,
    sum(t5.sun) as sun
from `personal`
left join (
    SELECT
        pers_id,
        IF(days = 1, worktime, null) as mon,
        IF(days = 2, worktime, null) as tue,
        IF(days = 3, worktime, null) as wed,
        IF(days = 4, worktime, null) as thu,
        IF(days = 5, worktime, null) as fri,
        IF(days = 6, worktime, null) as sat,
        IF(days = 7, worktime, null) as sun
    FROM (
        SELECT
			sum(worktime) as worktime,
            pers_id,
			days
        FROM (
            SELECT
				IF(DATE(date) = '2018-07-02', 1,
					IF(DATE(date) = '2018-07-03', 2,
						IF(DATE(date) = '2018-07-04', 3,
							IF(DATE(date) = '2018-07-05', 4,
                               IF(DATE(date) = '2018-07-06', 5,
                                  IF(DATE(date) = '2018-07-07', 6,
                                     IF(DATE(date) = '2018-07-08', 7, null)
                                    )
                                 )
                              )
                          )
                      )
                  ) as days,
            		pers_id,
            		worktime
            FROM personal_times
        ) as t1
        GROUP BY t1.pers_id, t1.days
    ) as t4
) as t5 on `t5`.`pers_id` = `personal`.`pers_id`
left join (
    SELECT
    	pers_id,
        IF(weeks = 1, sum, null) as week1,
        IF(weeks = 2, sum, null) as week2
    FROM (
        SELECT
			sum(worktime) as sum,
        	pers_id,
            weeks
        FROM (
            SELECT
            	IF(date BETWEEN '2018-06-25' AND '2018-07-01', 1,
                   	IF(date BETWEEN '2018-07-02' AND '2018-07-08', 2, null)
                  ) as weeks,
            		pers_id,
            		worktime
            FROM personal_times
        ) as pt
        WHERE weeks IS NOT NULL
        GROUP BY pt.weeks, pt.pers_id
    ) as t2
) as t3 on `t3`.`pers_id` = `personal`.`pers_id`
where `is_active` = 1 and `t3`.`pers_id` = 39
group by `personal`.`pers_id`