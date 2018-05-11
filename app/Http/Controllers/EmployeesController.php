<?php

namespace App\Http\Controllers;

class EmployeesController extends Controller
{
    /**
     * Index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('employees.index');
    }
}
