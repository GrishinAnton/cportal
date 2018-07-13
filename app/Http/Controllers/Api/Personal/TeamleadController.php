<?php

namespace App\Http\Controllers\Api\Personal;

use App\Http\Requests\ChangeTeamleadRequest;
use DB;
use App\Http\Requests\AddPersonalRequest;
use Mockery\Exception;
use App\Http\Resources\PersonalShortResource;
use App\Http\Resources\CompanyGroupResource;
use App\Http\Controllers\Controller;
use App\Personal;
use App\PersonalGroup;

class TeamleadController extends Controller
{

    /**
     * Get users with this teamlead
     *
     * @param $personalId
     * @return CompanyGroupResource
     */
    public function users($personalId)
    {
        $user = Personal::where('pers_id', $personalId)
            ->where('is_active', true)
            ->first();

        if (!$user) {
            abort(404);
        }

        $users = $user->teamleadPersonals();

        return PersonalShortResource::collection($users->paginate(75))
            ->additional(['success' => true]);
    }

    /**
     * Get users with this teamlead
     *
     * @param $personalId
     * @return CompanyGroupResource
     */
    public function teamlead($personalId)
    {
        $user = Personal::where('pers_id', $personalId)
            ->where('is_active', true)
            ->first();

        if (!$user) {
            abort(404);
        }

        $teamlead = $user->teamlead()->first();

        return !is_null ($teamlead) ?(new PersonalShortResource($teamlead))->additional([
            'success' => true
        ]) : null;
    }

    /**
     * get teamleads
     *
     * @param $personalId
     * @param GroupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function teamleads()
    {
        $group = PersonalGroup::where('index','teamlid')->first();

        if ($group) {
            $personals = Personal::where('group_id', $group->id)
                ->where('is_active', true)
                ->get();
        }

        return PersonalShortResource::collection($personals)
            ->additional(['success' => true]);
    }


    /**
     * add teamlead
     *
     * @param $personalId
     * @return CompanyGroupResource
     */
    public function addPersonal($personalId, AddPersonalRequest $request)
    {
        $user = Personal::where('pers_id', $personalId)->first();

        $owner = Personal::where('pers_id', $request->teamlead_id)->first();

        $user->update([
            'teamlead_id' => $owner->pers_id
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * change teamlead
     *
     * @param $personalId
     * @return CompanyGroupResource
     */
    public function reassigned($personalId, ChangeTeamleadRequest $request)
    {
        $teamlead = Personal::where('pers_id', $personalId)->first();
        if ($request->action == 'change') {
            $users = $teamlead->users()->get();
            foreach ($users as $user) {
                $user->update([
                    'teamlead_id' => $request->new_teamlead_id
                ]);
            }
            $teamlead->update([
                'group_id' => $request->group_id,
            ]);
        }

        if ($request->action == 'delete') {
            $users = $teamlead->users()->get();
            foreach ($users as $user) {
                $user->update([
                    'teamlead_id' => null
                ]);
            }
            //$teamlead->delete();
        }

        return response()->json(['success' => true]);
    }
}
