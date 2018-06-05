<?php

namespace App\Http\Controllers\Api\Report;

use App\Project;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function show($projectId)
    {
        $projects = Project::where('project_id', $projectId)
            ->first();

        dd($projects    );
    }
}
