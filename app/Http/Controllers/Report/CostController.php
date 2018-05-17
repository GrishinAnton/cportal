<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;

class CostController extends Controller
{
    /**
     * Show costs
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('finance.costs');
    }
}
