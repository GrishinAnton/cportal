<?php

namespace App\Http\Controllers\Api\Personal;

use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Personal;
use App\PersonalGroup;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Get all groups
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getGroups()
    {
        $personalGroups = PersonalGroup::select('id', 'name')->get();

        return GroupResource::collection($personalGroups)
            ->additional(['success' => true]);
    }

    /**
     * Add groups
     *
     * @param $personalId
     * @param GroupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addGroup($personalId, GroupRequest $request)
    {
        DB::beginTransaction();

        try {

            Personal::where('pers_id', $personalId)->update([
                'group_id' => $request->groupId
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            report($e);

            return response()->json(['success' => false]);
        }

        DB::commit();

        return response()->json(['success' => true]);
    }
}
