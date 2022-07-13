<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_name' => 'admin',
            'user_username' => 'admin',
            'email' => 'admin@softui.com',
            'password' => Hash::make('secret'),
            'user_role_id' => 1,
            'user_birthday' => now(),
            'user_address' => 'Surabaya',
            'user_phone' => '085156868587',
            'user_status' => 'Active',
        ]);
    }
}
