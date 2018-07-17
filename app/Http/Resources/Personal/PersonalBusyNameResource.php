<?php

namespace App\Http\Resources\Personal;

use App\PersonalTime;
use Illuminate\Http\Resources\Json\JsonResource;
use DateTime;

class PersonalBusyNameResource extends JsonResource
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
            'firstName'     => isset($this->resource['first_name']) ? $this->resource['first_name'] : null,
            'lastName'      => isset($this->resource['last_name']) ? $this->resource['last_name'] : null,
            'tasks'         => isset($this->resource['tasks']) ? PersonalBusyTaskResource::collection(collect($this->resource['tasks'])) : null,
        ];
    }
}
