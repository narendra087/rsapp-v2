<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Choice;

class ChoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Choice::create([
            'question_id' => 1,
            'choice' => 'Ya',
            'choice_other' => 0,
            'choice_default' => 1,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 1,
            'choice' => 'Tidak',
            'choice_other' => 0,
            'choice_default' => 0,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 3,
            'choice' => 'Ya',
            'choice_other' => 0,
            'choice_default' => 1,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 3,
            'choice' => 'Tidak',
            'choice_other' => 0,
            'choice_default' => 0,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 4,
            'choice' => 'Ya',
            'choice_other' => 0,
            'choice_default' => 1,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 4,
            'choice' => 'Tidak',
            'choice_other' => 0,
            'choice_default' => 0,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 8,
            'choice' => 'Demam',
            'choice_other' => 0,
            'choice_default' => 1,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 8,
            'choice' => 'Rasa Lelah',
            'choice_other' => 0,
            'choice_default' => 0,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 8,
            'choice' => 'Batuk Kering',
            'choice_other' => 0,
            'choice_default' => 0,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 8,
            'choice' => 'Rasa Nyeri',
            'choice_other' => 0,
            'choice_default' => 0,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 8,
            'choice' => 'Hidung Tersumbat',
            'choice_other' => 0,
            'choice_default' => 0,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 8,
            'choice' => 'Pilek',
            'choice_other' => 0,
            'choice_default' => 0,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 8,
            'choice' => 'Nyeri Kepala',
            'choice_other' => 0,
            'choice_default' => 0,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 8,
            'choice' => 'Konjungtivitis',
            'choice_other' => 0,
            'choice_default' => 0,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 8,
            'choice' => 'Sakit Tenggorokan',
            'choice_other' => 0,
            'choice_default' => 0,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 8,
            'choice' => 'Hilang Penciuman',
            'choice_other' => 0,
            'choice_default' => 0,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 8,
            'choice' => 'Ruam Kulit',
            'choice_other' => 0,
            'choice_default' => 0,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 8,
            'choice' => 'Diare',
            'choice_other' => 0,
            'choice_default' => 0,
            'choice_status' => 'Active'
        ]);
        Choice::create([
            'question_id' => 8,
            'choice' => 'Lainnya',
            'choice_other' => 1,
            'choice_default' => 0,
            'choice_status' => 'Active'
        ]);
    }
}
