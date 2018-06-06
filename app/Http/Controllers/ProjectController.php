<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use DateTime;

class ProjectController extends Controller
{
    /**
     * Show all projects
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $date = new DateTime('-1 month');
        
        $year = $date->format('Y');
        $month = $date->format('m');

        $projects = Project::with(['costs' => function ($query) use ($year, $month) {
            $query->whereMonth('date', $month)
            ->whereYear('date', $year);
        }])->with('fullInfoCosts')
            ->paginate(25);

        $fullInfoProjects = Project::with('costs');

        return view('projects.projects', compact('projects', 'fullInfoProjects'));
    }

    /**
     * Show one project
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id, Request $request)
    {
       return view('projects.show', compact('id'));
    }
}
