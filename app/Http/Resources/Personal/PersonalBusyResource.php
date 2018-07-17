<?php

namespace App\Http\Resources\Personal;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalBusyResource extends JsonResource
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
            'users'    => isset($this->resource['users']) ? PersonalBusyNameResource::collection(collect($this->resource['users'])) : null,
            'date'     => isset($this->resource['date']) ? $this->resource['date'] : null,
        ];
    }
}
