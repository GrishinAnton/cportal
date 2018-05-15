<?php

namespace App\Http\Controllers\Api\Personal;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalaryRequest;
use App\Http\Requests\ShowSalaryRequest;
use App\Http\Resources\SalaryResource;
use App\Salary;
use App\Personal;

class SalaryController extends Controller
{
    /**
     * Date year
     */
    private const DATE_YEAR = 0;

    /**
     * Date month
     */
    private const DATE_MONTH = 1;

    /**
     * Show salary for month and year
     *
     * @param $persId
     * @param ShowSalaryRequest $request
     * @return SalaryResource
     */
    public function show($persId, ShowSalaryRequest $request)
    {
        $date = explode('-', $request->date);

        $salary = Salary::select('id', 'coefficient', 'fix', 'salary', 'close_hours', 'salary_hours', 'penalty_hours')
            ->where('pers_id', $persId)
            ->whereYear('date', $date[self::DATE_YEAR])
            ->whereMonth('date', $date[self::DATE_MONTH])
            ->first();

        if (! $salary) {
            return response()->json(['success' => false]);
        }

        return (new SalaryResource($salary))
            ->additional(['success' => true]);
    }

    /**
     * Create salary
     *
     * @param SalaryRequest $request
     * @param $persId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SalaryRequest $request, $persId)
    {
        Personal::select('id')
            ->where('pers_id', $persId)
            ->firstOrFail();

        Salary::create([
            'pers_id' => $persId,
            'coefficient' => $request->coefficient,
            'fix' => $request->fix,
            'salary' => $request->salary,
            'close_hours' => $request->closeHours,
            'salary_hours' => $request->salaryHours,
            'penalty_hours' => $request->penaltyHours,
            'date' => $request->date,
        ]);
        
        return response()->json(['success' => true]);
    }

    /**
     * Update salary
     *
     * @param SalaryRequest $request
     * @param $salaryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SalaryRequest $request, $salaryId)
    {
        Salary::where('id', $salaryId)
            ->update([
                'coefficient' => $request->coefficient,
                'fix' => $request->fix,
                'salary' => $request->salary,
                'close_hours' => $request->closeHours,
                'salary_hours' => $request->salaryHours,
                'penalty_hours' => $request->penaltyHours,
            ]);

        return response()->json(['success' => true]);
    }
}
