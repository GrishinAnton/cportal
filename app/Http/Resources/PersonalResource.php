<?php

namespace App\Http\Resources;

use App\PersonalTime;
use Illuminate\Http\Resources\Json\JsonResource;
use DateTime;

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
            'id' => $this->id,
            'pers_id' => $this->pers_id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'url' => route('web.personal.show', ['id' => $this->pers_id]),
            'coefficient' => $this->getCoefficient($this->salary->first()),
            'closedHours' => round($this->times->sum('totaltime'), 2),
            'fine' => round($this->getFine($this) < 0 ? 0 : $this->getFine($this)),
            'salary' => $this->getSalary($this->salary->first()),
            'previousWeeksCloseHours' => round($this->previousWeeksCloseHours()->sum('worktime'), 2),
            'group' => (new GroupResource($this->group)),
            'company' => (new CompanyResource($this->company))
        ];
    }

    /**
     * Get work time previous weeks
     *
     * @return mixed
     */
    private function previousWeeksCloseHours()
    {
        $date = new DateTime('previous week monday');

        return PersonalTime::select('worktime')
            ->where('pers_id', $this->pers_id)
            ->whereDay('date', '>=', $date->format('d'))
            ->whereDay('date', '<=', $date->format('d') + 6)
            ->whereMonth('date', $date->format('m'))
            ->whereYear('date', $date->format('Y'))
            ->get();
    }

    /**
     * Get salary
     *
     * @param $salary
     * @return mixed
     */
    private function getSalary($salary)
    {
        if ($salary) {
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
