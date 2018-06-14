<?php

namespace App\Http\Resources\Report\Project;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ProjectResource extends JsonResource
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
            'hours_laid' => $this->resource->hours_laid,
            'cost_per_hour' => $this->resource->cost_per_hour,
        ];
    }
}
