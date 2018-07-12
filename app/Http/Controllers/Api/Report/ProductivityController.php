<?php

namespace App\Http\Controllers\Api\Report;

use DB;
use App\Personal;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\PersonalFilterRequest;
use App\Http\Resources\Report\ProductivityResource;
use App\Http\Resources\Report\ProductivityTwoWeekResource;

class ProductivityController extends Controller
{

    /**
     * Dates
     */
    public $days;
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
        $periodFrom = Carbon::now()->startOfWeek()->modify('-1 week')->format('Y-m-d');
        $periodTo = Carbon::now()->format('Y-m-d');

        $dates = $this->generateDateRange(Carbon::parse($periodFrom), Carbon::parse($periodTo));

        foreach ($dates as $date) {
            $timestamp = Carbon::parse($date)->getTimestamp();
            $select[] = "d$timestamp";
            $sum[] = "sum(d$timestamp) as d$timestamp";
            $if[] = "IF(date = '$date', sum, null) as d$timestamp";
        }

        $sqlPartIf = implode(',', $if);
        $sqlPartSum = implode(',', $sum);

        $allSelect = array_merge([
            'personal.id',
            'personal.first_name',
            'personal.last_name',
            'personal.pers_id'
        ], $select);


        $personal = Personal::select($allSelect)
            ->leftJoin(DB::raw("(
                SELECT 
                    pers_id,
                    $sqlPartSum  
                FROM (
                    SELECT
                        pers_id,        
                        $sqlPartIf
                    FROM (
                        SELECT
                           sum(worktime) as sum,
                           pers_id,
                           date
                        FROM personal_times   
                        WHERE date BETWEEN '{$periodFrom}' AND '{$periodTo}'
                        GROUP BY pers_id, date
                    ) as pt    
                ) as st
                group by pers_id) as at"), 'at.pers_id', '=', 'personal.pers_id')
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

    private function generateDateRange(Carbon $start_date, Carbon $end_date)
    {
        $dates = [];
        for($date = $start_date; $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }
        return $dates;
    }

    private function getLocalesDay($nameDay)
    {
        $locales = [
            'Mon' => 'Понедельник',
            'Tue' => 'Вторник',
            'Wed' => 'Среда',
            'Thu' => 'Четверг',
            'Fri' => 'Пятница',
            'Sat' => 'Суббота',
            'Sun' => 'Воскресенье',
        ];

        return $locales[$nameDay];
    }

    private function getDayNamesFromRange($dates)
    {
        $days = [];
        foreach ($dates as $key => $date) {
            $localeDay = date('D', strtotime($date));
            $nameDay = $this->getLocalesDay($localeDay);
            $key++;
            $days ['d'.$key] = $nameDay;
        }

        return $days;
    }

}
