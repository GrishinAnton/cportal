<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;

class WidgetController extends Controller
{
    /**
     * Index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('reports.widget.index');
    }
}
