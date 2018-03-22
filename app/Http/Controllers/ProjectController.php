<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\ProjectCost;
use DateTime;

class ProjectController extends Controller
{
    /**
    * Show all project
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $date = new DateTime('-1 month');
        
        $year = $date->format('Y');
        $month = $date->format('m');

        $projects = Project::with(['costs' => function ($query) use ($year, $month) {
            $query->where('year_month', $year.'-'.$month);
        }])->with('fullInfoCosts')
            ->paginate(25);

        $fullInfoProjects = Project::with('costs');


        return view('projects.projects', compact('projects', 'fullInfoProjects'));
    }

    /**
     * Show one projects
     *
     * @param [integer] $id
     * @param Request $request
     * @return view
     */
    public function show($id, Request $request)
    {
        $dates = ProjectCost::select('rus_date', 'year_month')->where('project_id', $id)
            ->orderBy('year_month', 'desc')->groupBy('rus_date')->get();

        //Если есть дата делаем переменную для запроса
        if ($request->filled('date')) {
            $date = $request->date;
        } else {
            $date = $dates->first()->year_month ?? date('Y-m');
        }

        $project = Project::where('project_id', $id)
            ->with(['costs' => function ($query) use ($date) {
                $query->where('year_month', $date)->with('pers');
            }])
            ->firstOrFail();
        
        return view('projects.show', compact('project', 'dates'));
    }
}
