<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert status data
        Status::create([
            'status_name'=>'Menunggu'
        ]);
        Status::create([
            'status_name'=>'Selesai'
        ]);
    }
}
