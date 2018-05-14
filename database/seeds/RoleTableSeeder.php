<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->params() as $param) {
            $role = Role::select('id')->where('name', $param['name'])->first();

            if ($role) {
                Role::where('name', $param['name'])->update($param);
            } else {
                Role::create($param);
            }
        }
    }

    /**
     * Get params
     *
     * @return array
     */
    private function params()
    {
        return [
            [
                'name' => 'user',
                'description' => 'Обычный пользователь'
            ]
        ];
    }
}
