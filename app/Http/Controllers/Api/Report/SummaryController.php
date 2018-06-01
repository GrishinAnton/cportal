<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonalFilterRequest;
use App\Http\Resources\Report\SummaryResource;
use App\Personal;
use DB;

class SummaryController extends Controller
{
    /**
     * Summary
     *
     * @param PersonalFilterRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(PersonalFilterRequest $request)
    {
        $personal = $this->queryProductivity($request->year ?? date('Y'))
            ->where('personal.is_active', true);

        foreach ($request->all() as $key => $filter) {
            try {
                $personal->{$key}($filter);
            } catch (\Exception $e) {
                report($e);
            }
        }

        return SummaryResource::collection($personal->paginate(75))
            ->additional(['success' => true]);
    }

    /**
     * Query productivity
     *
     * @return mixed
     */
    private function queryProductivity($year)
    {
        $personal = Personal::select(
            'personal.id',
            'personal.first_name',
            'personal.last_name',
            'personal.pers_id',
            DB::raw('t4.january as january'),
            DB::raw('t4.february as february'),
            DB::raw('t4.march as march'),
            DB::raw('t4.april as april'),
            DB::raw('t4.may as may'),
            DB::raw('t4.june as june'),
            DB::raw('t4.july as july'),
            DB::raw('t4.august as august'),
            DB::raw('t4.september as september'),
            DB::raw('t4.october as october'),
            DB::raw('t4.november as november'),
            DB::raw('t4.december as december')
        )
            ->leftJoin(DB::raw("(
                SELECT
                    sum(january) as january,
                    sum(february) as february,
                    sum(march) as march,
                    sum(april) as april,
                    sum(may) as may,
                    sum(june) as june,
                    sum(july) as july,
                    sum(august) as august,
                    sum(september) as september,
                    sum(october) as october,
                    sum(november) as november,
                    sum(december) as december,
                    pers_id,
                    date
                FROM (
                    SELECT
                        pers_id,
                        date,
                        IF(months = 1, salary, null) as january,
                        IF(months = 2, salary, null) as february,
                        IF(months = 3, salary, null) as march,
                        IF(months = 4, salary, null) as april,
                        IF(months = 5, salary, null) as may,
                        IF(months = 6, salary, null) as june,
                        IF(months = 7, salary, null) as july,
                        IF(months = 8, salary, null) as august,
                        IF(months = 9, salary, null) as september,
                        IF(months = 10, salary, null) as october,
                        IF(months = 11, salary, null) as november,
                        IF(months = 12, salary, null) as december
                    FROM (
                        SELECT 
                            MONTH(date) as months,
                            pers_id,
                            salary,
                            date
                        FROM salaries
                    ) as t2
                ) as t3 WHERE YEAR(date) = '{$year}' GROUP BY pers_id
            ) as t4"), 't4.pers_id', '=', 'personal.pers_id');

        return $personal;
    }
}
