<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalTimeResource extends JsonResource
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
            'worktime' => round($this->worktime, 2),
            'project' => $this->name,
            'projecId' => $this->project_id,
            'costOverride' => 0,
        ];
    }
}
