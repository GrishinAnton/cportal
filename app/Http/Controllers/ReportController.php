<?php

namespace App\Http\Controllers;

class ReportController extends Controller
{
    /**
     * Index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('report.index');
    }
}
