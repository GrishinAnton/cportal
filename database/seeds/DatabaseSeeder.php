<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PersonalGroupTableSeeder::class);
        $this->call(PersonalCompanyTableSeeder::class);
        $this->call(ProjectStatusTableSeeder::class);
    }
}
