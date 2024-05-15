<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'prefixname' => 'Mr.',
                'firstname' => 'John',
                'middlename' => 'Doe',
                'lastname' => 'Smith',
                'suffixname' => 'Jr.',
                'username' => 'johndoe',
                'email' => 'johndoe@example.com',
                'photo' => null,
                'type' => 'admin',
                'email_verified_at' => now(),
                'password' => bcrypt('1234'),
                'remember_token' => Str::random(10),
            ]
        ];

        DB::table('users')->insert($users);
    }
}
