<?php

namespace App\Http\Controllers;

class ProductivityController extends Controller
{
    /**
     * Index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('productivity.index');
    }

    /**
     * Productivity two week
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function indexTwoWeek()
    {
        return view('productivity.index_two_week');
    }
}
