<?php

namespace App\Http\Controllers\Api\Personal;

use App\Http\Requests\AddPersonalRequest;
use App\Http\Requests\PersonalFilterRequest;
use App\Http\Resources\CompanyGroupResource;
use App\Http\Resources\PersonalResource;
use App\Http\Controllers\Controller;
use App\Personal;
use DB;
use DateTime;

class PersonalController extends Controller
{
    /**
     * Index
     *
     * @param PersonalFilterRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(PersonalFilterRequest $request)
    {
        $personal = $this->personal();

        foreach ($request->all() as $key => $filter) {
            try {
                $personal->{$key}($filter);
            } catch (\Exception $e) {
                report($e);
            }
        }

        return PersonalResource::collection($personal->paginate(75))
            ->additional(['success' => true]);
    }

    /**
     * Get company and group personal
     *
     * @param $personalId
     * @return CompanyGroupResource
     */
    public function getCompanyGroupPersonal($personalId)
    {
        $personal = Personal::select('company_id', 'group_id')
            ->where('pers_id', $personalId)
            ->with('company', 'group')
            ->firstOrFail();

        return (new CompanyGroupResource($personal))->additional([
            'success' => true
        ]);
    }

    /**
     * Get company and group personal
     *
     * @param $personalId
     * @return CompanyGroupResource
     */
    public function addPersonal($personalId, AddPersonalRequest $request)
    {
        $user = Personal::find($personalId);
        $owner = Personal::find($request->pers_id);

        $user->owners()->sync([
            'owner_id'  => $owner->id,
            'user_id'  => $user->id,
            'group_id'  => $owner->group_id
            ]
        );

        return response()->json(['success' => true]);
    }

    /**
     * Personal query
     *
     * @return mixed
     */
    private function personal()
    {
        $date = new DateTime('-1 month');

        $year = $date->format('Y');
        $month = $date->format('m');

        $personal = Personal::where('is_active', true)
            ->with(['times' => function ($query) use ($month, $year) {
                $query->select(DB::raw('sum(worktime) as totaltime'), 'worktime', 'pers_id', 'task_id')
                    ->whereYear('date', $year)
                    ->whereMonth('date', $month)
                    ->groupBy('task_id')
                    ->groupBy('pers_id');
            }])->with(['salary' => function ($query) use ($month, $year) {
                $query->whereYear('date', $year)
                    ->whereMonth('date', $month)
                    ->orderBy('date', 'desc');
            }]);

        return $personal;
    }
}
