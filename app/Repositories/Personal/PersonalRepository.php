<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 13.07.18
 * Time: 17:57
 */

namespace App\Repositories\Personal;

use DB;
use Carbon\Carbon;
use App\Personal;
use App\PersonalTime;

class PersonalRepository
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
     * get hours 1 week
     *
     * @param $projectId
     * @return $this
     */
    public function getHoursWeek($personalId)
    {
        $week = PersonalTime::selectRaw('sum(worktime) as worktime, date')
            ->where('pers_id', $personalId)
            ->whereBetween('date', [$this->getStartOfWeekDate('-1 week'), $this->getEndOfWeekDate('-1 week')])
            ->groupBy('date')
            ->get();

        return $week;
    }

    public function getHours6Week($personalId)
    {
        $weeks = Personal::select(
            DB::raw("sum(t3.week1) as '{$this->getStartOfWeekDate('-1 week', 'd.m')}-{$this->getEndOfWeekDate('-1 week', 'd.m')}'"),
            DB::raw("sum(t3.week2) as '{$this->getStartOfWeekDate('-2 week', 'd.m')}-{$this->getEndOfWeekDate('-2 week', 'd.m')}'"),
            DB::raw("sum(t3.week3) as '{$this->getStartOfWeekDate('-3 week','d.m')}-{$this->getEndOfWeekDate('-3 week', 'd.m')}'"),
            DB::raw("sum(t3.week4) as '{$this->getStartOfWeekDate('-4 week', 'd.m')}-{$this->getEndOfWeekDate('-4 week', 'd.m')}'"),
            DB::raw("sum(t3.week5) as '{$this->getStartOfWeekDate('-5 week', 'd.m')}-{$this->getEndOfWeekDate('-5 week', 'd.m')}'"),
            DB::raw("sum(t3.week6) as '{$this->getStartOfWeekDate('-6 week', 'd.m')}-{$this->getEndOfWeekDate('-6 week', 'd.m')}'")
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
                        WHERE weeks IS NOT NULL and pt.pers_id = '{$personalId}'
                        GROUP BY pt.weeks
                    ) as t2 ) as t3"), 't3.pers_id', '=', 'personal.pers_id')
            ->where('personal.pers_id', $personalId)
            ->where('is_active', true)
            ->first();

        return $weeks;
    }

    public function getHours3Months($personalId)
    {
        $months = Personal::select(
            DB::raw("sum(t3.month1) as '{$this->getStartOfMonthDate('-1 month', 'F')}'"),
            DB::raw("sum(t3.month2) as '{$this->getStartOfMonthDate('-2 month', 'F')}'"),
            DB::raw("sum(t3.month3) as '{$this->getStartOfMonthDate('-3 month','F')}'")
        )
            ->leftJoin(DB::raw("(
                    SELECT
                        pers_id,
                        IF(months = 1, sum, null) as month1,
                        IF(months = 2, sum, null) as month2,
                        IF(months = 3, sum, null) as month3
                    FROM (
                        SELECT
                            sum(worktime) as sum,
                            pers_id,
                            months
                        FROM (
                            SELECT
                                IF(date BETWEEN '{$this->getStartOfMonthDate('-1 month')}' AND '{$this->getEndOfMonthDate('-1 month')}', 1,
                                    IF(date BETWEEN '{$this->getStartOfMonthDate('-2 month')}' AND '{$this->getEndOfMonthDate('-2 month')}', 2,
                                        IF(date BETWEEN '{$this->getStartOfMonthDate('-3 month')}' AND '{$this->getEndOfMonthDate('-3 month')}', 3, null)
                                    )
                                ) as months,
                                pers_id,
                                worktime
                            FROM personal_times
                        ) as pt
                        WHERE months IS NOT NULL and pt.pers_id = '{$personalId}'
                        GROUP BY pt.months
                    ) as t2 ) as t3"), 't3.pers_id', '=', 'personal.pers_id')
            ->where('personal.pers_id', $personalId)
            ->where('is_active', true)
            ->first();

        return $months;
    }

    public function getHoursMonth($personalId)
    {
        $month = PersonalTime::selectRaw('sum(worktime) as worktime, date')
            ->where('pers_id', $personalId)
            ->whereBetween('date', [Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->format('Y-m-d')])
            ->groupBy('date')
            ->get();

        return $month;
    }

    /**
     * Get start of week date
     *
     * @param $modify
     * @return string
     */
    private function getStartOfWeekDate($modify, $format = 'Y-m-d')
    {
        return Carbon::now()->modify($modify)->startOfWeek()->format($format);
    }

    /**
     * Get end if week date
     *
     * @param $modify
     * @return string
     */
    private function getEndOfWeekDate($modify, $format = 'Y-m-d')
    {
        return Carbon::now()->modify($modify)->endOfWeek()->format($format);
    }

    /**
     * Get start of month date
     *
     * @param $modify
     * @param string $format
     * @return string
     */
    private function getStartOfMonthDate($modify, $format = 'Y-m-d')
    {
        return Carbon::now()->modify($modify)->startOfMonth()->format($format);
    }

    /**
     * Get end of moth
     *
     * @param $modify
     * @param string $format
     * @return string
     */
    private function getEndOfMonthDate($modify, $format = 'Y-m-d')
    {
        return Carbon::now()->modify($modify)->endOfMonth()->format($format);
    }
}