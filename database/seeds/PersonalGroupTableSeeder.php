<?php

use Illuminate\Database\Seeder;
use App\PersonalGroup;

class PersonalGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->params() as $param) {
            $personalGroup = PersonalGroup::select('id')
                ->where('index', $param['index'])
                ->first();

            if ($personalGroup) {
                $personalGroup->update($param);
            } else {
                PersonalGroup::create($param);
            }
        }
    }

    /**
     * Params for seeder
     *
     * @return array
     */
    private function params()
    {
        return [
            [
                'name' => 'Программисты',
                'index' => 'programmers',
            ],
            [
                'name' => 'Менеджеры',
                'index' => 'managers',
            ],
            [
                'name' => 'Дизайнеры',
                'index' => 'designers',
            ],
            [
                'name' => 'Контент',
                'index' => 'content',
            ],
            [
                'name' => 'Другие',
                'index' => 'other',
            ],
            [
                'name' => 'Тимлид',
                'index' => 'teamlid',
            ]
        ];
    }
}
