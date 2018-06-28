<?php

namespace App\Console\Commands;

use App\Mail\ClosedTime;
use App\Personal;
use App\PersonalTime;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ClosedTimeEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:closed-time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email from closed time to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //$carbon = Carbon::setLocale('ru');

        setlocale(LC_TIME, 'Russia');

        Carbon::setLocale('ru');

        //Carbon::parse('2018-06-28')->format('D');

        dd(Carbon::parse('2018-06-28')->format('D'));

//        $personals = Personal::select('first_name', 'last_name', 'email', 'pers_id')
//            ->where('is_active', true)
//            ->where('pers_id', 39)
//            ->get();

        //foreach ($personals as $personal) {
            $personalTimes = PersonalTime::selectRaw('sum(worktime) as worktime, date')
                ->where('pers_id', 39)
                ->whereBetween('date', [$this->getStartOfWeekDate('-1 week'), $this->getEndOfWeekDate('-1 week')])
                ->groupBy('date')
                ->get();

            Mail::to('test@test.test')
                ->send((new ClosedTime($personalTimes))
                ->onQueue('emails'));

//
//            Mail::to('test@test.test')->onQueue('emails')->send(new ClosedTime($personalTimes));
//
//            $message = (new ClosedTime($personalTimes))
//                ->onQueue('emails');
//
//            Mail::to('test@test.test')
//                ->queue($message);
       // }
    }

    /**
     * Get start of week date
     *
     * @param $modify
     * @return string
     */
    private function getStartOfWeekDate($modify)
    {
        return Carbon::now()->modify($modify)->startOfWeek()->format('Y-m-d');
    }

    /**
     * Get end if week date
     *
     * @param $modify
     * @return string
     */
    private function getEndOfWeekDate($modify)
    {
        return Carbon::now()->modify($modify)->endOfWeek()->format('Y-m-d');
    }
}
