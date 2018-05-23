<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectCostResource extends JsonResource
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
            'worktime' => $this->hours,
            'project' => $this->projects->name,
            'percent' => $this->percent,
            'costOverride' => $this->cost_override,
            'projectCost' => $this->project_cost,
        ];
    }
}
+