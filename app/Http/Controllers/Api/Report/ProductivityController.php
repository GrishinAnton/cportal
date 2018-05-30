<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\ProductivityResource;
use App\Personal;
use Carbon\Carbon;
use DB;

class ProductivityController extends Controller
{
    public function index()
    {
        $personal =  Personal::select(
                'personal.id',
                'personal.first_name',
                'personal.last_name',
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
                            IF(date BETWEEN '{$this->getStartOfWeekDate('-1 week')}' AND '{$this->getEndOfWeekDate('-1 week')}', 1,
                                IF(date BETWEEN '{$this->getStartOfWeekDate('-2 week')}' AND '{$this->getEndOfWeekDate('-2 week')}', 2,
                                    IF(date BETWEEN '{$this->getStartOfWeekDate('-3 week')}' AND '{$this->getEndOfWeekDate('-3 week')}', 3,
                                        IF(date BETWEEN '{$this->getStartOfWeekDate('-4 week')}' AND '{$this->getEndOfWeekDate('-4 week')}', 4,
                                            IF(date BETWEEN '{$this->getStartOfWeekDate('-5 week')}' AND '{$this->getEndOfWeekDate('-5 week')}', 5,
                                                IF(date BETWEEN '{$this->getStartOfWeekDate('-6 week')}' AND '{$this->getEndOfWeekDate('-6 week')}', 6, null)
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
            ->paginate(75);

        return ProductivityResource::collection($personal)
            ->additional(['success' => true]);
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
