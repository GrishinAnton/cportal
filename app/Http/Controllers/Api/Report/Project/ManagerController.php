<?php

namespace App\Http\Controllers\Api\Report\Project;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\Project\ManagerResource;
use App\Personal;
use App\PersonalGroup;

class ManagerController extends Controller
{
    /**
     * Index manager
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $personalGroup = PersonalGroup::select('id')
            ->where('index', 'managers')
            ->first();

        $personal = Personal::select('first_name', 'last_name', 'id')
            ->where('group_id', $personalGroup->id)
            ->get();

        return ManagerResource::collection($personal)
            ->additional(['success' => true]);
    }
}
