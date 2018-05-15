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
            'closeHours' => $this->closeHours,
            'salaryHours' => $this->salaryHours,
            'penaltyHours' => $this->penaltyHours,
        ];
    }
}
