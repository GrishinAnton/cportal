<?php

use Illuminate\Database\Seeder;
use App\ProjectStatus;

class ProjectStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->params() as $param) {
            $projectStatus = ProjectStatus::select('id')
                ->where('index', $param['index'])
                ->first();

            if ($projectStatus) {
                $projectStatus->update($param);
            } else {
                ProjectStatus::create($param);
            }
        }
    }

    /**
     * Params
     *
     * @return array
     */
    private function params()
    {
        return [
            [
                'name' => 'Старт',
                'index' => 'start',
            ],
            [
                'name' => 'В работе',
                'index' => 'in_work',
            ],
            [
                'name' => 'Готов',
                'index' => 'ready',
            ],
            [
                'name' => 'Кейс',
                'index' => 'case',
            ],
            [
                'name' => 'Пиар',
                'index' => 'pr',
            ],
        ];
    }
}
