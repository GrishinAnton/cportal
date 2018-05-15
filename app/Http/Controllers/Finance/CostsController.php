<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Cost;
use App\Http\Requests\Finance\EditCostsForMonthRequest;

class CostsController extends Controller
{
    /**
     * Show costs
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @param EditCostsForMonthRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(EditCostsForMonthRequest $request)
    {
        Cost::where('rus_date', $request->date)
            ->update($request->only('cost'));
        
        return redirect()->back();
    }
}
