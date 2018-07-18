<?php

namespace App\Http\Resources\Personal;

use App\PersonalTime;
use Illuminate\Http\Resources\Json\JsonResource;
use DateTime;

class PersonalBusyTaskResource extends JsonResource
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
            'name'              =>  $this->resource['name'],
            'estimated_time'    =>  $this->resource['estimated_time'],
            'task_list'         =>  $this->resource['task_list'],
            'worktime'          =>  $this->resource['worktime'],
            'different'         =>  $this->resource['different'],
            'date_start'        =>  $this->resource['date_start'],
        ];
    }
}
