<?php

namespace App\Http\Controllers\Api\Report\Project;

use App\Http\Resources\CompanyResource;
use App\PersonalCompany;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    /**
     * Get companies
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $personalCompany = PersonalCompany::select('id', 'name')->get();

        return CompanyResource::collection($personalCompany)
            ->additional(['success' => true]);
    }
}
