<?php

namespace App\Http\Resources\Report\Project;

use App\Console\Commands\Api\TimeRecords;
use App\PersonalTime;
use Illuminate\Http\Resources\Json\JsonResource;

class HourSpentResource extends JsonResource
{
    /**
     * Date month
     */
    private const DATE_MONTH = 1;

    /**
     * Date year
     */
    private const DATE_YEAR = 0;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        foreach (collect($this->resource)->except(['first_name', 'last_name', 'pers_id']) as $key => $item) {
            $explode = explode('-', $key);

            $personalTime = PersonalTime::selectRaw('sum(worktime) as worktime')
                ->whereYear('date', $explode[static::DATE_YEAR])
                ->whereMonth('date', $explode[static::DATE_MONTH])
                ->where('pers_id', $this->resource->pers_id)
                ->first();

            $itemTime = $item;
            $workTime = $personalTime->worktime;
            
            try {
                $procent = 100 / ($workTime / $itemTime);
            } catch (\Exception $e) {
                $procent = 0;
            }

            $times[] = ($item ?? 0) .' (' . round($procent) . '%)';
        }

        return [
            'id' => $this->resource->pers_id,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'url' => route('web.personal.show', ['id' => $this->pers_id]),
            'times' => $times,
        ];
    }
}
