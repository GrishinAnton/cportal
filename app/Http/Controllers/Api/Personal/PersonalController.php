<?php

namespace App\Http\Controllers\Api\Personal;

use App\Http\Requests\AddPersonalRequest;
use App\Http\Requests\PersonalFilterRequest;
use App\Http\Resources\CompanyGroupResource;
use App\Http\Resources\PersonalResource;
use App\Http\Controllers\Controller;
use App\Personal;
use Carbon\Carbon;
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
        $user = Personal::where('pers_id', $request->user_id)->first();
        if (!$user) {
            return response()->errors(make_error('not_found', 'Пользователь не найден.'), 404);
        }
        $owner = Personal::where('pers_id', $request->owner_id)->first();
        if (!$owner) {
            return response()->errors(make_error('not_found', 'Добавляемый пользователь не найден.'), 404);
        }
        DB::table('user_to_user')->insert([
            'owner_id'  => $owner->pers_id,
            'user_id'  => $user->pers_id,
            'group_id'  => $owner->group_id,
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);

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
