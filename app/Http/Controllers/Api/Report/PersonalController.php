<?php

namespace App\Http\Controllers\Api\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Personal;
use App\Salary;

class PersonalController extends Controller
{
    public function all()
    {
        $users = Personal::where('is_active', true)
            ->with('salary')
            ->get();

        return response()->json(
            [
                'success' => true,
                'data' => $users
            ]
        );
    }

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
