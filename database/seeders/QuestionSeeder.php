<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //insert QS Contract Tracing
        Question::create([
            'question_segment_id' => 1,
            'question_detail' => 'Dalam 14 hari terakhir apakah kontak dengan orang yang terkonfirmasi positif COVID-19?',
            'question_type' => 'boolean',
            'question_required' => 1,
            'question_disabled' => 0
        ]);
        Question::create([
            'question_segment_id' => 1,
            'question_detail' => 'Dalam 14 hari terakhir kontak erat dengan siapa saja?',
            'question_type' => 'text',
            'question_required' => 1,
            'question_disabled' => 0
        ]);

        //insert QS Surveillance
        Question::create([
            'question_segment_id' => 2,
            'question_detail' => 'Apakah anda tinggal di daerah zona merah?',
            'question_type' => 'boolean',
            'question_required' => 1,
            'question_disabled' => 0
        ]);
        Question::create([
            'question_segment_id' => 2,
            'question_detail' => 'Apakah di tempat tinggal anda ada yang terkonfirmasi positif COVID-19?',
            'question_type' => 'boolean',
            'question_required' => 1,
            'question_disabled' => 0
        ]);

        //insert QS Riwayat Vaksin
        Question::create([
            'question_segment_id' => 3,
            'question_detail' => 'Riwayat Vaksin',
            'question_type' => 'textarea',
            'question_required' => 1,
            'question_disabled' => 0
        ]);

        //insert QS Form Keluhan
        Question::create([
            'question_segment_id' => 4,
            'question_detail' => 'Keluhan utama Anda',
            'question_type' => 'textarea',
            'question_required' => 1,
            'question_disabled' => 0
        ]);
        Question::create([
            'question_segment_id' => 4,
            'question_detail' => 'Riwayat penyakit Anda saat ini',
            'question_type' => 'textarea',
            'question_required' => 1,
            'question_disabled' => 0
        ]);
        Question::create([
            'question_segment_id' => 4,
            'question_detail' => 'Gejala yang muncul saat ini',
            'question_type' => 'options',
            'question_required' => 1,
            'question_disabled' => 0
        ]);

        //insert QS Kesehatan Jiwa dan Dukungan Psikologis
        Question::create([
            'question_segment_id' => 5,
            'question_detail' => 'Bagaimana perasaan anda saat ini?',
            'question_type' => 'textarea',
            'question_required' => 1,
            'question_disabled' => 0
        ]);
        Question::create([
            'question_segment_id' => 5,
            'question_detail' => 'Bagaimana pemenuhan kebutuhan sehari-hari anda saat menjalani isolasi mandiri?',
            'question_type' => 'textarea',
            'question_required' => 1,
            'question_disabled' => 0
        ]);

        //insert QS Aspek Budaya
        Question::create([
            'question_segment_id' => 6,
            'question_detail' => 'Bagaimana pandangan anda mengenai COVID-19?',
            'question_type' => 'textarea',
            'question_required' => 1,
            'question_disabled' => 0
        ]);
        Question::create([
            'question_segment_id' => 6,
            'question_detail' => 'Bagaimana pandangan orang disekitar / lingkungan anda mengenai COVID-19?',
            'question_type' => 'textarea',
            'question_required' => 1,
            'question_disabled' => 0
        ]);

        //insert QS Pemeriksaan Fisik
        Question::create([
            'question_segment_id' => 7,
            'question_detail' => 'Suhu',
            'question_type' => 'text',
            'question_required' => 1,
            'question_disabled' => 0
        ]);
        Question::create([
            'question_segment_id' => 7,
            'question_detail' => 'Saturasi Oksigen',
            'question_type' => 'text',
            'question_required' => 1,
            'question_disabled' => 0
        ]);
        Question::create([
            'question_segment_id' => 7,
            'question_detail' => 'HR (Denyut jantung dalam 1 menit)',
            'question_type' => 'text',
            'question_required' => 1,
            'question_disabled' => 0
        ]);
        Question::create([
            'question_segment_id' => 7,
            'question_detail' => 'RR (Napas dalam 1 menit)',
            'question_type' => 'text',
            'question_required' => 1,
            'question_disabled' => 0
        ]);
        Question::create([
            'question_segment_id' => 7,
            'question_detail' => 'Tekanan darah',
            'question_type' => 'text',
            'question_required' => 1,
            'question_disabled' => 0
        ]);

        //insert QS Pemeriksaan Penunjang
        Question::create([
            'question_segment_id' => 8,
            'question_detail' => 'Hasil Lab SWAB',
            'question_type' => 'file',
            'question_required' => 1,
            'question_disabled' => 0
        ]);
        Question::create([
            'question_segment_id' => 8,
            'question_detail' => 'Hasil Lab',
            'question_type' => 'file',
            'question_required' => 1,
            'question_disabled' => 0
        ]);
        Question::create([
            'question_segment_id' => 8,
            'question_detail' => 'Hasil Radiologi',
            'question_type' => 'file',
            'question_required' => 1,
            'question_disabled' => 0
        ]);

        //insert QS Analisis
        Question::create([
            'question_segment_id' => 9,
            'question_detail' => 'Pengumpulan Data',
            'question_type' => 'textarea',
            'question_required' => 1,
            'question_disabled' => 0
        ]);
        Question::create([
            'question_segment_id' => 9,
            'question_detail' => 'Etiologi',
            'question_type' => 'textarea',
            'question_required' => 1,
            'question_disabled' => 0
        ]);
        Question::create([
            'question_segment_id' => 9,
            'question_detail' => 'Masalah',
            'question_type' => 'textarea',
            'question_required' => 1,
            'question_disabled' => 0
        ]);

        //insert QS Prioritas
        Question::create([
            'question_segment_id' => 10,
            'question_detail' => 'Prioritas Masalah',
            'question_type' => 'textarea',
            'question_required' => 1,
            'question_disabled' => 0
        ]);

        //insert QS Diagnosa
        Question::create([
            'question_segment_id' => 11,
            'question_detail' => 'Diagnosa Medis',
            'question_type' => 'textarea',
            'question_required' => 1,
            'question_disabled' => 0
        ]);

        //insert QS Terapi
        Question::create([
            'question_segment_id' => 12,
            'question_detail' => 'Terapi Yang Dilakukan',
            'question_type' => 'textarea',
            'question_required' => 1,
            'question_disabled' => 0
        ]);
    }
}
