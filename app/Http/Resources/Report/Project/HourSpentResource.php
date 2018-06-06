<?php

namespace App\Http\Resources\Report\Project;

use Illuminate\Http\Resources\Json\JsonResource;

class HourSpentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $info = [
            'id' => $this->resource->id,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
        ];

        unset($this->resource->id);
        unset($this->resource->first_name);
        unset($this->resource->last_name);

        return [
            'info' => $info,
            'times' => $this->resource,
        ];
    }
}
