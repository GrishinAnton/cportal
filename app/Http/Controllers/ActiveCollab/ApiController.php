<?php

namespace App\Http\Controllers\ActiveCollab;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class ApiController extends Controller
{
    /**
     * Index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('active_collab.index');
    }

    /**
     * Import personal
     *
     * @return string
     */
    public function personal()
    {
        Artisan::call('api:personal');

        return 'Персонал выгружен!';
    }

    /**
     * Import projects
     *
     * @return string
     */
    public function projects()
    {
        Artisan::call('api:projects');

        return 'Проекты выгружены!';
    }

    /**
     * Import Tasks
     *
     * @return string
     */
    public function tasks()
    {
        Artisan::call('api:tasks');

        return 'Задачи выгружены!';
    }

    /**
     * Import Time Records
     *
     * @return string
     */
    public function timeRecords()
    {
        Artisan::call('api:timerecords');

        return 'Затреканное время выгруженно!';
    }

    /**
     * Clear and Import Time records
     *
     * @return string
     */
    public function timeRecordsAll()
    {
        Artisan::call('api:timerecords', [
            'all' => true,
        ]);

        return 'Затреканное время отчищенно и снова выгруженно';
    }
}
