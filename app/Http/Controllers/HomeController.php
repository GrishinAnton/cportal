<?php

namespace App\Http\Controllers;

use App\Personal;
use App\Project;
use App\Task;
use Illuminate\Http\Request;
use App\PersonalTime;
use Carbon\Carbon;
use App\Cost;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
