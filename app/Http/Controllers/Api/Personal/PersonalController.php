<?php

namespace App\Http\Controllers\Api\Personal;

use App\Http\Requests\PersonalFilterRequest;
use App\Http\Resources\PersonalResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Personal;
use DB;
use App\ProjectCost;
use App\Salary;
use App\Cost;
use App\Http\Requests\EditSalaryRequest;
use App\Http\Requests\WriteOffCostsRequest;
use DateTime;

class PersonalController extends Controller
{
    /**
     * Index
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(PersonalFilterRequest $request)
    {
        $personal = $this->personal();

        foreach ($request->all() as $key => $filter) {
            try {
                $personal->{$key}($filter);
            } catch (\Exception $e) {
                report($e);
            }
        }

        return PersonalResource::collection($personal->paginate(50))
            ->additional(['success' => true]);
    }

    /**
     * Personal query
     *
     * @return mixed
     */
    private function personal()
    {
        $date = new DateTime('-1 month');

        $year = $date->format('Y');
        $month = $date->format('m');

        $personal = Personal::where('is_active', 1)
            ->with(['times' => function ($query) use ($month, $year) {
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
            }]);

        return $personal;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EditSalaryRequest $request
     * @param $pers_id
     * @param null $salary_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeSalary(EditSalaryRequest $request, $pers_id, $salary_id = null)
    {
        $create = Salary::updateOrCreate(
            [
                'id' => $salary_id
            ],
            [
                'salary' => $request->salary,
                'salary_fix' => $request->salaryFix,
                'hour' => $request->hour,
                'coefficient' => $request->coef,
                'date' => $request->date,
                'pers_id' => $pers_id,
                'edit_salary' => $request->editSalary,
                'edit_hours' => $request->editHours
            ]
        );

        $salary = Salary::find($create->id);

        return response()->json($salary);
    }

    /**
     * Add costs for projects first worker
     *
     * @param $pers_id
     * @param WriteOffCostsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeCosts($pers_id, WriteOffCostsRequest $request)
    {
        if ($request->filled('date')) {
            $date = rus_date([$request->date => $request->date]);

            $date = $date[$request->date];
        } else {
            $date = rus_date([date('Y-m') => date('Y-m')]);

            $date = $date[date('Y-m')];
        }

        ProjectCost::create([
            'pers_id' => $pers_id,
            'project_id' => $request->projectId,
            'project_cost' => $request->projectCost,
            'hours' => $request->workTime,
            'rus_date' => $date,
            'year_month' => $request->date
        ]);

        return response()->json('helloworld');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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

        $salary = $first->salary->first();

        $timeRecords = Personal::findOrFail($id, ['pers_id'])
            ->projects()
                ->select([
                    'projects.*',
                    't.worktime',
                ])
                ->leftJoin(
                    DB::raw("(SELECT
                        project_id,
                        sum(worktime) as worktime
                    FROM (
                            SELECT 
                                tasks.project_id,
                                tr.worktime
                            FROM tasks JOIN (
                                SELECT 
                                    task_id, sum(worktime) as worktime
                                FROM 
                                    personal_times
                                WHERE 
                                    pers_id = ".$id." and 
                                    MONTH(date) = ".(int)$date[1]." and 
                                    year(date) = ".(int)$date[0]."
                                GROUP BY 
                                    task_id, date
                            ) as tr on tr.task_id = tasks.task_id
                        ) as tmp
                        GROUP BY tmp.project_id ) as t"),
                    't.project_id',
                    '=',
                    'projects.project_id'
                )
                ->with(['costs' => function ($query) use ($id, $date) {
                    $query->where('year_month', $date[0].'-'.$date[1])
                        ->where('pers_id', $id);
                }])
            ->get();

        $costs = Cost::where('year', $date[0])
            ->where('month', $date[1])
            ->select('cost')
            ->first();

        $projectCosts = ProjectCost::select('id')->where('year_month', $date[0].'-'.$date[1])
            ->where('pers_id', $id)
            ->first();

        return response()->json([
            'first' => $first,
            'salary' => $salary,
            'timeRecords' => $timeRecords,
            'costs' => $costs,
            'projectCosts' => $projectCosts ? true : false
        ]);
    }
}
