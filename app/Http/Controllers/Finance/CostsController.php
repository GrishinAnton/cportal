<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PersonalTime;
use Carbon\Carbon;
use App\Cost;
use App\Http\Requests\Finance\EditCostsForMonthRequest;

class CostsController extends Controller
{
     /**
     * Show Costs
     *
     * @return view
     */
    public function index()
    {
        $costs = Cost::where('year', date('Y'))->select('rus_date', 'cost')
            ->orderBy('month')->get();

        return view('finance.costs', compact('costs'));
    }

    /**
     * Edit costs
     *
     * @param Request $request
     * @return redirect
     */
    public function edit(EditCostsForMonthRequest $request)
    {
        Cost::where('rus_date', $request->date)
            ->update($request->only('cost'));
        
        return redirect()->back();
    }
}
