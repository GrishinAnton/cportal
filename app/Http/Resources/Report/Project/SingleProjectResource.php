<?php

namespace App\Http\Resources\Report\Project;

use Carbon\Carbon;
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
            'start' => Carbon::parse($this->resource->start_at)->format('d/m/Y'),
            'finish' => Carbon::parse($this->resource->finish_at)->format('d/m/Y'),
            'company' => $this->resource->company_id,
            'status' => $this->resource->status_id,
            'hoursLaid' => $this->resource->hours_laid,
            'costPerHour' => $this->resource->cost_per_hour,
        ];
    }
}
