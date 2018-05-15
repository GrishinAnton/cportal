<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\PersonalTime;
use DB;

class WorkTimeController extends Controller
{
    /**
     * Work time by month
     *
     * @param $year
     * @return \Illuminate\Http\JsonResponse
     */
    public function workTimeByMonth($year)
    {
        $personalTime = PersonalTime::select(DB::raw('sum(worktime) as total_worktime'))
            ->whereYear('date', $year)
            ->orderBy('date', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $personalTime
        ]);
    }
}
