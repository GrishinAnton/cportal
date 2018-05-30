<?php

namespace App\Console\Commands\Api;

use Illuminate\Console\Command;
use App\Task;
use App\Subtask;

class Tasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download tasks from api';

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
     * Hangle
     *
     * @throws \ActiveCollab\SDK\Exceptions\Authentication
     */
    public function handle()
    {
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

        $tasks = $client->get('/reports/run?type=AssignmentFilter&include_subtasks=false&include_tracking_data=true')
            ->getJson();

        foreach ($tasks['all']['assignments'] as $task) {
            Task::updateOrCreate(
                [
                    'task_id' => $task['id']
                ],
                [
                    'type' => $task['type'],
                    'permalink' => $task['permalink'],
                    'name' => $task['name'],
                    'completed_on' => $task['completed_on'],
                    'is_completed' => isset($task['completed_on']) ? true : false,
                    'project_id' => $task['project_id'],
                    'created_on' => $task['created_on'],
                    'assignee_id' => $task['assignee_id'],
                    'tracked_time' => $task['tracked_time'] ?? 0,
                    'estimated_time' => $task['estimated_time']
                ]
            );

            if (isset($task['subtasks'])) {
                foreach ($task['subtasks'] as $subtask) {
                    Subtask::updateOrCreate(
                        [
                            'subtask_id' => $subtask['id']
                        ],
                        [
                            'task_id' => $subtask['task_id'],
                            'assignee_id' => $subtask['assignee_id'],
                            'body' => $subtask['body'],
                            'created_on' => $subtask['created_on'],
                            'permalink' => $subtask['permalink'],
                            'completed_on' => $subtask['completed_on'],
                            'is_completed' => isset($subtask['completed_on']) ? true : false,
                            'type' => $subtask['type']
                        ]
                    );
                }
            }
        }
    }
}
