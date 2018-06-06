<?php

namespace App\Http\Resources\Report\Project;

use Illuminate\Http\Resources\Json\JsonResource;

class HourSpentHeaderResource extends JsonResource
{
    /**
     * Date month
     */
    private const DATE_MONTH = 0;

    /**
     * Date year
     */
    private const DATE_YEAR = 1;

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
        unset($array['id']);
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

        if ($explode[static::DATE_MONTH] == 'January') {
            return 'Январь ' . $explode[static::DATE_YEAR];
        } elseif ($explode[static::DATE_MONTH] == 'February') {
            return 'Февраль ' . $explode[static::DATE_YEAR];
        } elseif ($explode[static::DATE_MONTH] == 'March') {
            return 'Март ' . $explode[static::DATE_YEAR];
        } elseif ($explode[static::DATE_MONTH] == 'April') {
            return 'Апрель ' . $explode[static::DATE_YEAR];
        } elseif ($explode[static::DATE_MONTH] == 'May') {
            return 'Май ' . $explode[static::DATE_YEAR];
        } elseif ($explode[static::DATE_MONTH] == 'June') {
            return 'Июнь ' . $explode[static::DATE_YEAR];
        } elseif ($explode[static::DATE_MONTH] == 'July') {
            return 'Июль ' . $explode[static::DATE_YEAR];
        } elseif ($explode[static::DATE_MONTH] == 'August') {
            return 'Август ' . $explode[static::DATE_YEAR];
        } elseif ($explode[static::DATE_MONTH] == 'September') {
            return 'Сентябрь ' . $explode[static::DATE_YEAR];
        } elseif ($explode[static::DATE_MONTH] == 'October') {
            return 'Октябрь ' . $explode[static::DATE_YEAR];
        } elseif ($explode[static::DATE_MONTH] == 'November') {
            return 'Ноябрь ' . $explode[static::DATE_YEAR];
        } elseif ($explode[static::DATE_MONTH] == 'December') {
            return 'Декабрь ' . $explode[static::DATE_YEAR];
        }
    }
}
