<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->params() as $param) {
            $user = User::select('id')->where('email', $param['email'])->first();

            if ($user) {
                User::where('name', $param['name'])->update($param);
            } else {
                User::create($param);
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
                'name' => 'King',
                'email' => 'king@2-up.ru',
                'password' => bcrypt('helloworld'),
                'role_id' => 1
            ]
        ];
    }
}
