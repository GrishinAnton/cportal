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
            'url' => route('web.personal.show', ['id' => $this->pers_id]),
            'week1' => [
                'hours' => $this->week1 ? round($this->week1, 2) : 0,
                'date' => $this->getWeekMonthDay('-6 week')
            ],
            'week2' => [
                'hours' => $this->week2 ? round($this->week2, 2) : 0,
                'date' => $this->getWeekMonthDay('-5 week')
            ],
            'week3' => [
                'hours' => $this->week3 ? round($this->week3, 2) : 0,
                'date' => $this->getWeekMonthDay('-4 week')
            ],
            'week4' => [
                'hours' => $this->week4 ? round($this->week4, 2) : 0,
                'date' => $this->getWeekMonthDay('-3 week')
            ],
            'week5' => [
                'hours' => $this->week5 ? round($this->week5, 2) : 0,
                'date' => $this->getWeekMonthDay('-2 week')
            ],
            'week6' => [
                'hours' => $this->week6 ? round($this->week6, 2) : 0,
                'date' => $this->getWeekMonthDay('-1 week')
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
