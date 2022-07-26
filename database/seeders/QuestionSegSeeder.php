<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Form;
use App\Models\QuestionSegment;

class QuestionSegSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //insert forms data
        Form::create([
            'form_name'=>'Form Pasien'
        ]);
        Form::create([
            'form_name'=>'Form Analisis Perawat'
        ]);
        Form::create([
            'form_name'=>'Form Diagnosis dan Terapi Dokter'
        ]);

        //insert question segments data
        QuestionSegment::create([
            'form_id' => 1,
            'question_segment' => 'Contract Tracing',
            'question_segment_status' => 'active'
        ]);
        QuestionSegment::create([
            'form_id' => 1,
            'question_segment' => 'Surveillance',
            'question_segment_status' => 'active'
        ]);
        QuestionSegment::create([
            'form_id' => 1,
            'question_segment' => 'Riwayat Vaksin',
            'question_segment_status' => 'active'
        ]);
        QuestionSegment::create([
            'form_id' => 1,
            'question_segment' => 'Form Keluhan',
            'question_segment_status' => 'active'
        ]);
        QuestionSegment::create([
            'form_id' => 1,
            'question_segment' => 'Kesehatan Jiwa dan Dukungan Psikologis',
            'question_segment_status' => 'active'
        ]);
        QuestionSegment::create([
            'form_id' => 1,
            'question_segment' => 'Aspek Budaya',
            'question_segment_status' => 'active'
        ]);
        QuestionSegment::create([
            'form_id' => 1,
            'question_segment' => 'Pemeriksaan Fisik',
            'question_segment_status' => 'active'
        ]);
        QuestionSegment::create([
            'form_id' => 1,
            'question_segment' => 'Pemeriksaan Penunjang',
            'question_segment_status' => 'active'
        ]);
        QuestionSegment::create([
            'form_id' => 2,
            'question_segment' => 'Analisis Masalah',
            'question_segment_status' => 'active'
        ]);
        QuestionSegment::create([
            'form_id' => 2,
            'question_segment' => 'Prioritas',
            'question_segment_status' => 'active'
        ]);
        QuestionSegment::create([
            'form_id' => 3,
            'question_segment' => 'Diagnosa Medis',
            'question_segment_status' => 'active'
        ]);
        QuestionSegment::create([
            'form_id' => 3,
            'question_segment' => 'Terapi',
            'question_segment_status' => 'active'
        ]);
    }
}
