<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\PersonalResource;
use App\Personal;
use App\Salary;

class PersonalController extends Controller
{
    /**
     * Get all personal
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $personal = Personal::where('is_active', true)
            ->with('salary')
            ->get();

        return PersonalResource::collection($personal)
            ->additional(['success' => true]);
    }

    /**
     * Get salaries
     *
     * @param $persId
     * @param $year
     * @param $month
     * @return \Illuminate\Http\JsonResponse
     */
    public function salaries($persId, $year, $month)
    {
        $salaries = Salary::where('pers_id', $persId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->first();

        return response()->json([
            'success' => true,
            'data' => $salaries
        ]);
    }
}
