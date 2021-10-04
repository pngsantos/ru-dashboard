<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert(
            [
                'first_name' => 'RU',
                'last_name' => 'Admin',
                'email' => 'admin@railings.io',
                'password' => bcrypt('test1234'),
                'type' => 'admin',
                'is_admin' => '1',
                'status' => 'active'
            ]
        );
    }
}
