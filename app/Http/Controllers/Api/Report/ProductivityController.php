<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Personal;
use Carbon\Carbon;

class ProductivityController extends Controller
{
    public function index()
    {
        $personal = Personal::with(['times' => function ($query) {
            $query->whereBetween('date', [
                Carbon::now()
                    ->modify('-1 week')
                    ->startOfWeek(),
                Carbon::now()
                    ->modify('-1 week')
                    ->endOfWeek(),
            ]);
        }])
            ->take(1)->get();

        dd($personal);

        return Carbon::now()
            ->modify('-3 week')
            ->startOfWeek();

    }
}

//SELECT p.id, p.email, sum(t3.week1), sum(t3.week2)
//FROM personal as p
//LEFT JOIN
//(
//    SELECT
//		pers_id,
//		IF(weeks = 1, sum, null) as week1,
//		IF(weeks = 2, sum, null) as week2
//	FROM (
//        SELECT
//    		sum(worktime) as sum,
//    		pers_id,
//        	weeks
//    	FROM (
//            SELECT
//        		IF(`date` BETWEEN '2018-02-01' AND '2018-03-01', 1,
//            		IF(`date` BETWEEN '2018-03-02' AND '2018-04-02', 2, null)
//            	) as `weeks`,
//        		pers_id,
//        		worktime
//        	FROM personal_times
//    	) as pt
//    	WHERE weeks IS NOT NULL
//    	GROUP BY pt.weeks, pt.pers_id
//   ) as t2
//) AS t3 ON t3.pers_id=p.id
//GROUP BY p.id
