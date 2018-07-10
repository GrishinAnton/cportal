<?php

namespace App\Http\Controllers\Api\Personal;

use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Personal;
use App\PersonalCompany;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    /**
     * Get personal companies
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getCompanies()
    {
        $personalCompanies = PersonalCompany::select('id', 'name')->get();

        return CompanyResource::collection($personalCompanies)
            ->additional(['success' => true]);
    }

    /**
     * Add company
     *
     * @param $personalId
     * @param CompanyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCompany($personalId, CompanyRequest $request)
    {
        Personal::where('pers_id', $personalId)->update([
            'company_id' => $request->companyId
        ]);

        return response()->json(['success' => true]);
    }
}
