<?php

namespace App\Http\Controllers\Api\Personal;

use App\Cost;
use App\Http\Requests\DateRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Personal\CostResource;

class CostController extends Controller
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
     * Show cost for personal
     *
     * @param DateRequest $request
     * @return CostResource
     */
    public function index(DateRequest $request)
    {
        $date = explode('-', $request->date);

        $cost = Cost::select('cost')
            ->whereYear('date', $date[self::DATE_YEAR])
            ->whereMonth('date', $date[self::DATE_MONTH])
            ->first();

        if (! $cost) {
            return (new CostResource($cost))
                ->additional(['success' => false]);
        }

        return (new CostResource($cost))
            ->additional(['success' => true]);
    }
}
