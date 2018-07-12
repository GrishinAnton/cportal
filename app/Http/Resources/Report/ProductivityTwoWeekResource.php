<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ProductivityTwoWeekResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lastWeek = Carbon::now()->startOfWeek()->modify('-1 week')->format('Y-m-d');
        $now = Carbon::now()->format('Y-m-d');
        //dates and hours current week
        $startThisWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $datesThisWeek = $this->generateDateRange(Carbon::parse($startThisWeek), Carbon::parse($now));
        $daysThisWeek = $this->getDayNamesFromRange($datesThisWeek);
        $daysWithKeyThisWeek = $this->getDayNamesFromRangeWithKey($datesThisWeek);
        $thisWeekHoursSum = 0;

        //dates and hours on last week
        $datesLastWeek = $this->generateDateRange(Carbon::parse($lastWeek), Carbon::parse($startThisWeek)->subDay(1));
        $daysLastWeek = $this->getDayNamesFromRange($datesLastWeek);
        $daysWithKeyLastWeek = $this->getDayNamesFromRangeWithKey($datesLastWeek);
        $hoursLastWeekSum = 0;

        $personal = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'url' => route('web.personal.show', ['id' => $this->pers_id]),
        ];
        $hoursThisWeek = [];
        foreach ($datesLastWeek as $date) {

            $hoursLastWeekSum += $this->{array_search($daysLastWeek[$date], $daysWithKeyLastWeek)};
        }

        $weekendHours = 0;
        foreach ($datesThisWeek as $date) {

            if (!in_array($daysThisWeek[$date], ['Суббота', 'Воскресенье'])) {
                $hoursThisWeek[$daysThisWeek[$date]] = [

                    'hours' => $this->{array_search($daysThisWeek[$date], $daysWithKeyThisWeek)},
                ];
            } else {
                $weekendHours += $this->{array_search($daysThisWeek[$date], $daysWithKeyThisWeek)};
                $hoursThisWeek['Выходные'] = [
                    'hours' => $weekendHours,
                ];

            }

            $thisWeekHoursSum += $this->{array_search($daysThisWeek[$date], $daysWithKeyThisWeek)};
        }

        return array_merge( [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'url' => route('web.personal.show', ['id' => $this->pers_id]),
        ],
            $hoursThisWeek, ['current_week_hours' => $thisWeekHoursSum], ['last_week_hours' => $hoursLastWeekSum]);
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
        foreach ($dates as $date) {
            $localeDay = date('D', strtotime($date));
            $nameDay = $this->getLocalesDay($localeDay);
            $days [$date] = $nameDay;
        }

        return $days;
    }

    private function getDayNamesFromRangeWithKey($dates)
    {
        $days = [];
        foreach ($dates as $key => $date) {
            $localeDay = date('D', strtotime($date));
            $nameDay = $this->getLocalesDay($localeDay);
            $timestamp = Carbon::parse($date)->getTimestamp();
            $days ['d'.$timestamp] = $nameDay;
        }

        return $days;
    }

    /**
     * Get week day
     *
     * @param $modify
     * @return string
     */
    private function getWeekMonthDay($modify)
    {
        $date = Carbon::now()->modify($modify)->startOfWeek()->format('d.m')
            . '-' . Carbon::now()->modify($modify)->endOfWeek()->format('d.m');

        return $date;
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
