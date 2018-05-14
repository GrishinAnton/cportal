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
}
