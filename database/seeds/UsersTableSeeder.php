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
        User::create([
            'name' => 'King',
            'email' => 'king@2-up.ru',
            'password' => bcrypt('helloworld'),
            'role_id' => 1
        ]);
    }
}
