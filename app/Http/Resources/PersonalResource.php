<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'url' => route('web.personal.show', ['id' => $this->pers_id]),
            'coefficient' => $this->getCoefficient($this->salary),
            'closedHours' => $this->times->sum('totaltime'),
            'fine' => $this->getFine($this) < 0 ? 0 : $this->getFine($this),
            'salary' => $this->getSalary($this->salary)
        ];
    }

    /**
     * Get salary
     *
     * @param $salary
     * @return mixed
     */
    private function getSalary($salary)
    {
        if ($salary->isNotEmpty()) {
            return ! empty($salary->edit_salary) ? $salary->edit_salary : $salary->salary;
        }

        return 0;
    }

    /**
     * Get coefficient
     *
     * @param $salary
     * @return float
     */
    private function getCoefficient($salary)
    {
        return isset($salary->coefficient) ? $salary->coefficient : 1.1;
    }

    /**
     * Get fine
     *
     * @param $info
     * @return float|int
     */
    private function getFine($info)
    {
        return $info->times->sum('totaltime')
            - ($info->tasks->sum('estimated_time')
                * (isset($info->salary->coefficient) ? $info->salary->coefficient : 1.1));
    }
}
