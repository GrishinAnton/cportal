<?php

namespace App\Console\Commands\Api;

use Illuminate\Console\Command;
use App\Personal as Pers;

class Personal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:personal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download personal from api';

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

        $personal = $client->get('/users/all')->getJson();
        
        foreach ($personal as $pers) {
            Pers::updateOrCreate(
                [
                    'pers_id' => $pers['id'],
                ],
                [
                    'avatar' => $pers['avatar_url'],
                    'class' => $pers['class'],
                    'created_on' => $pers['created_on'],
                    'email' => $pers['email'],
                    'first_name' => $pers['first_name'],
                    'is_archived' => $pers['is_archived'],
                    'is_trashed' => $pers['is_trashed'],
                    'last_name' => $pers['last_name'],
                    'phone' => $pers['phone'],
                    'trashed_on' => $pers['trashed_on'],
                    'updated_on' => $pers['updated_on'],
                    'url_path' => $pers['url_path'],
                ]
            );
        }
    }
}
