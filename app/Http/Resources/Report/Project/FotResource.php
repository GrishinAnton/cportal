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
        return $this->resource;
    }
}
