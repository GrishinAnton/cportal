<?php

namespace App\Http\Controllers\Api\Report;

use App\Cost;
use App\Http\Requests\CostRequest;
use App\Http\Requests\DateRequest;
use App\Http\Resources\CostResource;
use App\Http\Controllers\Controller;

class CostController extends Controller
{
    /**
     * Date year
     */
    private const DATE_YEAR = 0;

    /**
     * Get all costs by year
     *
     * @param DateRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(DateRequest $request)
    {
        $date = explode('-', $request->date);

        $costs = Cost::select('date', 'cost', 'id')
            ->whereYear('date', $date[self::DATE_YEAR])
            ->orderBy('date', 'desc')
            ->get();

        return CostResource::collection($costs)
            ->additional(['success' => true]);
    }

    /**
     * Create costs
     *
     * @param CostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CostRequest $request)
    {
        Cost::create([
            'cost' => $request->cost,
            'date' => $request->date
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Update costs
     *
     * @param $costId
     * @param CostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($costId, CostRequest $request)
    {
        Cost::where('id', $costId)
            ->update([
                'cost' => $request->cost
            ]);

        return response()->json(['success' => true]);
    }
}
