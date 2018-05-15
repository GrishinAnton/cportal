<?php

namespace App\Http\Controllers\Api\Personal;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalaryRequest;
use App\Salary;
use App\Personal;

class SalaryController extends Controller
{
    /**
     * Create salary
     *
     * @param SalaryRequest $request
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
            'date' => date('Y-m-d')
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
