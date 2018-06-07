<?php

namespace App\Http\Resources\Report\Project;

use Illuminate\Http\Resources\Json\JsonResource;

class HourSpentHeaderResource extends JsonResource
{
    /**
     * Date month
     */
    private const DATE_MONTH = 1;

    /**
     * Date year
     */
    private const DATE_YEAR = 0;

    /**
     * @var array
     */
    private $months = [
        1 => 'Январь',
        2 => 'Февраль',
        3 => 'Март',
        4 => 'Апрель',
        5 => 'Май',
        6 => 'Июнь',
        7 => 'Июль',
        8 => 'Август',
        9 => 'Сентябрь',
        10 => 'Октябрь',
        11 => 'Ноябрь',
        12 => 'Декабрь',
    ];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $dates = $this->first()->toArray();

        return array_merge([
            '#',
            'Имя Фамилия'
        ], $this->ruKey($dates));
    }

    /**
     * Clear array
     *
     * @param $array
     * @return mixed
     */
    private function clearArray($array)
    {
        unset($array['pers_id']);
        unset($array['first_name']);
        unset($array['last_name']);

        return $array;
    }

    /**
     * Ru key for header
     *
     * @param $array
     * @return array
     */
    private function ruKey($array)
    {
        $newArray = [];

        foreach ($this->clearArray($array) as $key => $item) {
            $newArray[] = $this->parseString($key);
        }

        return $newArray;
    }

    /**
     * Parse string
     *
     * @param $string
     * @return string
     */
    private function parseString($string)
    {
        $explode = explode('-', $string);

        foreach ($this->months as $key => $month) {
            if ($explode[static::DATE_MONTH] == $key) {
                return $month . ' ' . $explode[static::DATE_YEAR];
            }
        }
    }
}
