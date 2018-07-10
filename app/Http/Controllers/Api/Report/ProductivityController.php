<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonalFilterRequest;
use App\Http\Resources\Report\ProductivityResource;
use App\Http\Resources\Report\ProductivityTwoWeekResource;
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
     * Productivity two week
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function indexTwoWeek(PersonalFilterRequest $request)
    {
        $personal = $this->queryTwoWeekProductivity();

        foreach ($request->all() as $key => $filter) {
            try {
                $personal->{$key}($filter);
            } catch (\Exception $e) {
                report($e);
            }
        }

        return ProductivityTwoWeekResource::collection($personal->paginate(75))
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
     * Query productivity
     *
     * @return mixed
     */
    private function queryTwoWeekProductivity()
    {
//        $personal = Personal::select(
//            'personal.id',
//            'personal.first_name',
//            'personal.last_name',
//            'personal.pers_id'
//        )
//            ->leftJoin('personal_times as pt', function($query)
//            {
//                $query->on('pt.pers_id', '=', 'personal.pers_id');
//                $query->selectRaw('COUNT(id) as week1');
//            })
//            ->groupBy('personal.id')
//            ->where('is_active', true);


        $personal = Personal::select(
            'personal.id',
            'personal.first_name',
            'personal.last_name',
            'personal.pers_id',
            DB::raw('sum(t3.week1) as week1'),
            DB::raw('sum(t3.week2) as week2'),
            DB::raw('sum(t3.day1) as day1'),
            DB::raw('sum(t3.day2) as day2'),
            DB::raw('sum(t3.day3) as day3'),
            DB::raw('sum(t3.day4) as day4'),
            DB::raw('sum(t3.day5) as day5'),
            DB::raw('sum(t3.day6) as day6'),
            DB::raw('sum(t3.day7) as day7')


        )
            ->leftJoin(DB::raw("(
                SELECT
                    pers_id,
                    IF(weeks = 1, sum, null) as week1,
                    IF(weeks = 2, sum, null) as week2,
                    IF(weeks = 3, sum, null) as day1,
                    IF(weeks = 4, sum, null) as day2,
                    IF(weeks = 5, sum, null) as day3,
                    IF(weeks = 6, sum, null) as day4,
                    IF(weeks = 7, sum, null) as day5,
                    IF(weeks = 8, sum, null) as day6,
                    IF(weeks = 9, sum, null) as day7
                FROM (
                    SELECT
                        sum(worktime) as sum,
                        pers_id,
                        weeks
                    FROM (
                        SELECT
                            IF(date BETWEEN '{$this->getCurrentDateWithModify('-2 week')}' AND '{$this->getCurrentDate()}', 1,
                                IF(date BETWEEN '{$this->getCurrentDateWithModify('-1 week')}' AND '{$this->getCurrentDate()}', 2,
                                    IF(date BETWEEN '{$this->getCurrentDateWithModify('-6 day')}' AND '{$this->getCurrentDate()}', 3,
                                        IF(date BETWEEN '{$this->getCurrentDateWithModify('-5 day')}' AND '{$this->getCurrentDate()}', 4,
                                            IF(date BETWEEN '{$this->getCurrentDateWithModify('-4 day')}' AND '{$this->getCurrentDate()}', 5,
                                                IF(date BETWEEN '{$this->getCurrentDateWithModify('-3 day')}' AND '{$this->getCurrentDate()}', 6,
                                                    IF(date BETWEEN '{$this->getCurrentDateWithModify('-2 day')}' AND '{$this->getCurrentDate()}', 7,
                                                        IF(date BETWEEN '{$this->getCurrentDateWithModify('-1 day')}' AND '{$this->getCurrentDate()}', 8,
                                                            IF(date = '{$this->getCurrentDate()}', 9, null)
                                                        )
                                                    )
                                                )                                                
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

    /**
     * Get current date with modify
     *
     * @param $modify
     * @return string
     */
    private function getCurrentDateWithModify($modify)
    {
        return Carbon::now()->modify($modify)->format('Y-m-d');
    }

    /**
     * Get current date with modify
     *
     * @param $modify
     * @return string
     */
    private function getCurrentDate()
    {
        return Carbon::now()->format('Y-m-d');
    }
}
