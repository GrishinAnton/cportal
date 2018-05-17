<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CostResource extends JsonResource
{
    /**
     * Date month
     */
    private const DATE_MONTH = 1;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'cost' => $this->cost,
            'month' => $this->getMonth($this->date),
        ];
    }

    /**
     * Get month
     *
     * @param $date
     * @return mixed
     */
    private function getMonth($date)
    {
        $date = explode('-', $date);

        return $date[self::DATE_MONTH];
    }
}
