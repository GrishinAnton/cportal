<?php

namespace App\Console\Commands\Api;

use Illuminate\Console\Command;
use App\Project;

class Projects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:projects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download from api projects';

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

        $projects = $client->get('/projects')->getJson();
        
        foreach ($projects as $project) {
            $id = Project::updateOrCreate(
                [
                    'project_id' => $project['id']
                ],
                [
                    'class' => $project['class'],
                    'url_path' => $project['url_path'],
                    'name' => $project['name'],
                    'category_id' => $project['category_id'],
                    'is_trashed' => $project['is_trashed'],
                    'trashed_on' => $project['trashed_on'],
                    'updated_on' => $project['updated_on'],
                    'body_formatted' => $project['body_formatted'],
                    'company_id' => $project['company_id'],
                    'currency_id' => $project['currency_id'],
                    'budget' => $project['budget'] ?? 0,
                    'is_completed' => $project['is_completed']
                ]
            );

            $manytomany = Project::find($id->id);

            $manytomany->personal()->sync($project['members']);
        }

        $archives = $client->get('projects/archive')->getJson();
        
        foreach ($archives as $archive) {
            $id = Project::updateOrCreate(
                [
                    'project_id' => $archive['id']
                ],
                [
                    'class' => $archive['class'],
                    'url_path' => $archive['url_path'],
                    'name' => $archive['name'],
                    'category_id' => $archive['category_id'],
                    'is_trashed' => $archive['is_trashed'],
                    'trashed_on' => $archive['trashed_on'],
                    'updated_on' => $archive['updated_on'],
                    'body_formatted' => $archive['body_formatted'],
                    'company_id' => $archive['company_id'],
                    'currency_id' => $archive['currency_id'],
                    'budget' => $archive['budget'] ?? 0,
                    'is_completed' => $archive['is_completed']
                ]
            );

            $manytomany = Project::find($id->id);
            
            $manytomany->personal()->sync($project['members']);
        }
    }
}
