<?php

namespace App\Http\Resources\Report\Project;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleProjectResource extends JsonResource
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
            'budget' => $this->resource->budget,
            'name' => $this->resource->name,
            'start' => $this->resource->start_at,
            'finish' => $this->resource->finish_at,
            'company' => $this->resource->company_id,
            'status' => $this->resource->status_id,
            'hoursLaid' => $this->resource->hours_laid,
            'costPerHour' => $this->resource->cost_per_hour,
        ];
    }
}
