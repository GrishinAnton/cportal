<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personal;
use DB;
use App\PersonalTime;
use App\Project;
use App\ProjectCost;
use Carbon\Carbon;
use App\Salary;
use App\Cost;
use App\Http\Requests\EditSalaryRequest;
use App\Http\Requests\EditCoefRequest;
use App\Http\Requests\WriteOffCostsRequest;
use DateTime;

class PersonalController extends Controller
{
    /**
    * Show active worker
    *
    * @return view
    */
    public function index()
    {
        $date = new DateTime('-1 month');
        
        $year = $date->format('Y');
        $month = $date->format('m');

        $personal = Personal::where('is_active', 1)->with(['times' => function ($query) use ($month, $year) {
            $query->select(DB::raw('sum(worktime) as totaltime'), 'worktime', 'pers_id', 'task_id')
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->groupBy('task_id')
                ->groupBy('pers_id');
        }])->with(['tasks' => function ($query) use ($month, $year) {
                $query->groupBy('task_id')
                    ->groupBy('personal_times.pers_id')
                    ->groupBy('personal_times.task_id')
                    ->whereMonth('personal_times.date', $month)
                    ->whereYear('personal_times.date', $year);
        }])->with(['salary' => function ($query) use ($month, $year) {
                $query->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->orderBy('date', 'desc');
        }])
            ->paginate(25);

        return view('personal.personal', compact('personal'));
    }

    /**
    * Show one worker
    *
    * @param Request $request
    * @param integer $id
    * @return view
    */
    public function show($id, Request $request)
    {
        //Если есть дата делаем переменную для запроса
        $date = input_date($request->filled('date'), $request->date);

        //Достаем все что вообще можно
        $first = Personal::where('is_active', 1)->where('pers_id', $id)
        ->with(['times' => function ($query) use ($date) {
            $query->select(DB::raw('sum(worktime) as totaltime'), 'worktime', 'pers_id', 'task_id')
                ->whereYear('date', (int)$date[0])
                ->whereMonth('date', (int)$date[1])
                ->groupBy('task_id')->with(['tasks' => function ($query) {
                    $query->with('projects');
                }]);
        }])->with(['salary' => function ($query) use ($date) {
                $query->whereYear('date', (int)$date[0])
                ->whereMonth('date', (int)$date[1])
                ->orderBy('date', 'desc');
        }])
            ->firstOrFail();

        //Достаем и групируем по месячно все даты
        $dates = PersonalTime::orderBy('date', 'DESC')->select('date')->get()
        ->groupBy(function ($events) {
            return Carbon::parse($events->date)->format('Y-m');
        });

        //Вывод красивой даты
        $dates = rus_date($dates);

        return view('personal.show', compact('dates', 'first'));
    }

    /**
     * Active, DeActive personal
     *
     * @param [integer] $pers_id
     * @param Request $request
     * @return back
     */
    public function store($pers_id, Request $request)
    {
        Personal::where('pers_id', $pers_id)->update([
            'is_active' => $request->is_active
        ]);

        return redirect('/personal');
    }
}
