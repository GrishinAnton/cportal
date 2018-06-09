<?php

namespace App\Http\Resources\Report\Project;

use Illuminate\Http\Resources\Json\JsonResource;

class CostResource extends JsonResource
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
            'id' => $this->resource->pers_id,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'url' => route('web.personal.show', ['id' => $this->pers_id]),
            'costs' => collect($this->resource)->except(['first_name', 'last_name', 'pers_id']),
        ];
    }
}
