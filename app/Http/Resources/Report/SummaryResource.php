<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\JsonResource;

class SummaryResource extends JsonResource
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
            'pers_id' => $this->pers_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'url' => route('web.personal.show', ['id' => $this->pers_id]),
            'salary' => [
                'january' => $this->january,
                'february' => $this->february,
                'march' => $this->march,
                'april' => $this->april,
                'may' => $this->may,
                'june' => $this->june,
                'july' => $this->july,
                'august' => $this->august,
                'september' => $this->september,
                'october' => $this->october,
                'november' => $this->november,
                'december' => $this->december,
            ],
        ];
    }
}
