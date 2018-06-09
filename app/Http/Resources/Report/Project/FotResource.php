<?php

namespace App\Http\Resources\Report\Project;

use Illuminate\Http\Resources\Json\JsonResource;

class FotResource extends JsonResource
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
            'pers_id' => $this->resource->pers_id,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'salaries' => collect($this->resource)->except(['first_name', 'last_name', 'pers_id']),
        ];
    }
}
