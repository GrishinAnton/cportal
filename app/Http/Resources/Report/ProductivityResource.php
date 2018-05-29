<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ProductivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'week1' => [
                'hours' => $this->week1,
                'date' => $this->getWeekMonthDay('-1 week')
            ],
            'week2' => [
                'hours' => $this->week2,
                'date' => $this->getWeekMonthDay('-2 week')
            ],
            'week3' => [
                'hours' => $this->week3,
                'date' => $this->getWeekMonthDay('-3 week')
            ],
            'week4' => [
                'hours' => $this->week4,
                'date' => $this->getWeekMonthDay('-4 week')
            ],
            'week5' => [
                'hours' => $this->week5,
                'date' => $this->getWeekMonthDay('-5 week')
            ],
            'week6' => [
                'hours' => $this->week6,
                'date' => $this->getWeekMonthDay('-6 week')
            ],
        ];
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
}
