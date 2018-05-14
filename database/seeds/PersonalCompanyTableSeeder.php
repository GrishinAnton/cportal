<?php

use Illuminate\Database\Seeder;
use App\PersonalCompany;

class PersonalCompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->params() as $param) {
            $personalGroup = PersonalCompany::where('index', $param)->first();

            if ($personalGroup) {
                PersonalCompany::where('index', $param)->update($param);
            } else {
                PersonalCompany::create($param);
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
                'name' => '2UP',
                'index' => '2up'
            ],
            [
                'name' => 'PROspace',
                'index' => 'prospace'
            ],
            [
                'name' => 'Web2print',
                'index' => 'web2print'
            ]
        ];
    }
}
