<?php

namespace App\Http\Controllers\Email;

use App\Mail\ClosingTimeTeamlid;
use App\Mail\ClosedTime;
use App\Personal;
use App\Repositories\Personal\PersonalRepository;
use Illuminate\Support\Facades\Mail;
use App\PersonalGroup;
use DB;
use App\Http\Controllers\Controller;


class PersonalTimeController extends Controller
{
    /**
     * @var CostRepository
     */
    private $personalRepository;

    /**
     * CostController constructor.
     */
    public function __construct()
    {
        $this->personalRepository = new PersonalRepository();
    }

    /**
     * Send email personal time
     *
     * @return string
     */
    public function send()
    {
        $personals = Personal::select('first_name', 'last_name', 'email', 'pers_id', 'group_id')
            ->where('is_active', true)
            ->get();

        $teamleadGroup = PersonalGroup::where('index','teamlid')->first();

        $teamleadPersonalsInfo = [];

        foreach ($personals as $personal) {
            $week = $this->personalRepository->getHoursWeek($personal->pers_id);
            $weeks = $this->personalRepository->getHours6Week($personal->pers_id);
            $months = $this->personalRepository->getHours3Months($personal->pers_id);

            $teamleadPersonals = $personal->teamleadPersonals()->get();

            foreach ($teamleadPersonals as $user) {
                $teamleadPersonalsInfo[$user->pers_id] = [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'week' => $this->personalRepository->getHoursWeek($user->pers_id),
                    'month' => $this->personalRepository->getHoursMonth($user->pers_id),
                ];
            }

            if ($personal->group_id != $teamleadGroup->id) {
//                Mail::to($personal->email)
//                    ->send((new ClosedTime($week, $weeks, $months, $personal))
//                        ->onQueue('emails'));
            } else {
                Mail::to($personal->email)
                    ->send((new ClosingTimeTeamlid($week, $weeks, $months, $personal, $teamleadPersonalsInfo))
                        ->onQueue('emails'));

            }
        }

        return 'Письма разосланы';
    }
}
