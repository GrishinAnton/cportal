<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SalaryResource extends JsonResource
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
            'id' => $this->id,
            'coefficient' => $this->coefficient,
            'fix' => $this->fix,
            'salary' => $this->salary,
            'closeHours' => $this->close_hours,
            'salaryHours' => $this->salary_hours,
            'penaltyHours' => $this->penalty_hours,
        ];
    }
}
