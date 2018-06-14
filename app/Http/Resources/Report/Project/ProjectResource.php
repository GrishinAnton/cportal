<?php

namespace App\Http\Resources\Report\Project;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'id' => $this->project_id,
            'name' => $this->name,
            'budget' => $this->budget,
            'status' => $this->status_name,
            'company' => $this->company_name,
            'url' => route('web.projects.show', ['id' => $this->id]),
        ];
    }
}
