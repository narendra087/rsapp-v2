<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      // Insert roles data
        Role::create([
          'role_name'=>'admin'
        ]);
        Role::create([
          'role_name'=>'dokter'
        ]);
        Role::create([
          'role_name'=>'perawat'
        ]);
        Role::create([
          'role_name'=>'pasien'
        ]);

        // Insert users data
        User::create([
            'user_role_id' => 1,
            'user_name' => 'admin',
            'user_username' => 'admin',
            'email' => 'admin@rsapp.com',
            'password' => Hash::make('secret'),
            'user_birthday' => now(),
            'user_address' => 'Surabaya',
            'user_phone' => '085156868587',
            'user_status' => 'Active',
        ]);
        User::create([
            'user_role_id' => 2,
            'user_name' => 'dokter',
            'user_username' => 'dokter',
            'email' => 'dokter@rsapp.com',
            'password' => Hash::make('secret'),
            'user_birthday' => now(),
            'user_address' => 'Surabaya',
            'user_phone' => '085156868587',
            'user_status' => 'Active',
        ]);
        User::create([
            'user_role_id' => 3,
            'user_name' => 'perawat',
            'user_username' => 'perawat',
            'email' => 'perawat@rsapp.com',
            'password' => Hash::make('secret'),
            'user_birthday' => now(),
            'user_address' => 'Surabaya',
            'user_phone' => '085156868587',
            'user_status' => 'Active',
        ]);
        User::create([
            'user_role_id' => 4,
            'user_name' => 'pasien',
            'user_username' => 'pasien',
            'email' => 'pasien@rsapp.com',
            'password' => Hash::make('secret'),
            'user_birthday' => now(),
            'user_address' => 'Surabaya',
            'user_phone' => '085156868587',
            'user_status' => 'Active',
        ]);
    }
}
