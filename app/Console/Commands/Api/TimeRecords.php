<?php

namespace App\Console\Commands\Api;

use Illuminate\Console\Command;
use App\Personal;
use App\PersonalTime;
use App\Task;

class TimeRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:timerecords {all?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download time records from api';

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
     * @throws \ActiveCollab\SDK\Exceptions\Authentication
     */
    public function handle()
    {
        //Подключаемся к api
        $authenticator = new \ActiveCollab\SDK\Authenticator\Cloud(
            env('ACTIVE_COLLAB_COMPANY'),
            env('ACTIVE_COLLAB_NAME'),
            env('ACTIVE_COLLAB_LOGIN'),
            env('ACTIVE_COLLAB_PASSWORD')
        );
        $authenticator->setSslVerifyPeer(false);

        $token = $authenticator->issueToken(144541);

        $client = new \ActiveCollab\SDK\Client($token);

        $client->setSslVerifyPeer(false);

        //Достаем персонал весь, чтобы достать все треки из api
        $personal = Personal::where('is_active', 1)->select('pers_id')->get();

        //Если есть в команде аргумент all, тогда достаем все, что можно иначе с послдней даты в бд
        if ($this->argument('all')) {
            $date = '2017-03-01';
        } else {
            $date = PersonalTime::select('date')->orderBy('date', 'desc')->first();
            
            $date = $date->date ?? '2017-03-01';
        }
        
        //Записываем в бд
        foreach ($personal as $pers) {
            $timeRecords = $client->get(
                '/users/'.$pers['pers_id'].'/time-records/filtered-by-date?from='.$date.'&to='.date('Y-m-d').''
            )
                ->getJson();

            if ($timeRecords) {
                if (! empty($timeRecords['related']['Task'])) {
                    foreach ($timeRecords['related']['Task'] as $task) {
                        Task::updateOrCreate(
                            [
                                'task_id' => $task['id']
                            ],
                            [
                                'type' => $task['class'],
                                'permalink' => 'https://app.activecollab.com/144541' . $task['url_path'],
                                'name' => $task['name'],
                                'completed_on' => $task['completed_on'],
                                'is_completed' => isset($task['completed_on']) ? true : false,
                                'project_id' => $task['project_id'],
                                'created_on' => $task['created_on'],
                                'assignee_id' => $task['assignee_id'],
                                'tracked_time' => $task['tracked_time'] ?? 0,
                                'estimated_time' => $task['estimate']
                            ]
                        );
                    }
                }
                foreach ($timeRecords['time_records'] as $timeRecord) {
                    $task = Task::select('task_id')->where('task_id', $timeRecord['parent_id'])->first();
                    if ($task) {
                        PersonalTime::firstOrCreate(
                            [
                                'timerecord_id' => $timeRecord['id']
                            ],
                            [
                                'worktime' => $timeRecord['value'],
                                'date' => date('Y-m-d', $timeRecord['record_date']),
                                'pers_id' => $timeRecord['user_id'],
                                'task_id' => $timeRecord['parent_id']
                            ]
                        );
                    }
                }
            }
        }
    }
}
