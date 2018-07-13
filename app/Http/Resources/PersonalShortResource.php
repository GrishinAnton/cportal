<?php

namespace App\Http\Resources;

use App\PersonalTime;
use Illuminate\Http\Resources\Json\JsonResource;
use DateTime;

class PersonalShortResource extends JsonResource
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
            'id' => $this->pers_id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'url' => route('web.personal.show', ['id' => $this->pers_id]),
        ];
    }
}
