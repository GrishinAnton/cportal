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
        $info = [
            'id' => $this->resource->pers_id,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
        ];

        $persId = $this->resource->pers_id;

        unset($this->resource->pers_id);
        unset($this->resource->first_name);
        unset($this->resource->last_name);

        foreach ($this->resource->getAttributes() as $key => $item) {
            $explode = explode('-', $key);

            $personalTime = PersonalTime::selectRaw('sum(worktime) as worktime')
                ->whereYear('date', $explode[static::DATE_YEAR])
                ->whereMonth('date', $explode[static::DATE_MONTH])
                ->where('pers_id', $persId)
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
            'info' => $info,
            'times' => $times,
        ];
    }
}
