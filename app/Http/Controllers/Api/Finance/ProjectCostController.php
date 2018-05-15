<?php

namespace App\Http\Controllers\Api\Finance;

use App\Http\Controllers\Controller;

class ProjectCostController extends Controller
{
    /**
     * Get all projects costs
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //$costs = Cost::where('')->get();

        return response()->json(['success' => true]);
    }
}
