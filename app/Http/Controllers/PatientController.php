<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\User;
use App\Models\Form;
use App\Models\Response;
use App\Models\Result;
use App\Models\Question;
use App\Models\QuestionSegment;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $response = Response::where('response_user_id', $id)
            ->join('answers', 'answers.answer_response_id', '=', 'responses.id')
            ->where('answer_question_id', 6)->get();

        // dump($response);
        return view('pasien/dashboard-pasien', compact('response'));
    }

    public function create()
    {
        $id = Auth::user()->id;
        $segments = Form::where('forms.id', 1)
        ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')->get();

        $questions = Form::where('forms.id', 1)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get();

        $choices = Form::where('forms.id', 1)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')
            ->leftJoin('choices', 'choices.question_id', '=', 'questions.id')->get();

        // dump($segments, $questions, $choices);
        return view('pasien/form-keluhan', compact('segments', 'questions', 'choices'));
    }

    public function store(Request $request)
    {
        // return $request->all();
        // return public_path('uploads');
        $id = Auth::user()->id;

        $this->validate($request, [
            '0' => ['nullable'],
            'question_1' => ['required'],
            'question_2' => ['required', 'max:150'],
            'question_3' => ['required'],
            'question_4' => ['required'],
            'question_5' => ['required', 'max:150'],
            'question_6' => ['required', 'max:150'],
            'question_7' => ['required', 'max:150'],
            'question_8' => ['required'],
            'question_9' => ['nullable'],
            'question_10' => ['nullable'],
            'question_11' => ['nullable'],
            'question_12' => ['nullable'],
            'question_13' => ['nullable', 'numeric', 'gt:0'],
            'question_14' => ['nullable', 'numeric', 'gt:0'],
            'question_15' => ['nullable', 'numeric', 'gt:0'],
            'question_16' => ['nullable', 'numeric', 'gt:0'],
            'question_17' => ['nullable'],
            'question_18' => ['nullable'],
            'question_19' => ['nullable', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
            'question_20' => ['nullable', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
            'question_21' => ['nullable', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ],[
            '*.required' => 'Bagian ini diperlukan.',
            '*.max' => 'Bagian ini tidak boleh melebihi 150 karakter',
            '*.numeric' => 'Bagian ini harus berisi angka.',
            '*.gt' => 'Bagian ini berisi masukan yang tidak valid.',
            '*.mimes' => 'Format file tidak sesuai (jpeg, jpg, png, pdf)',
            'question_19.max' => 'Ukuran file terlalu besar. (maks 2mb)',
            'question_20.max' => 'Ukuran file terlalu besar. (maks 2mb)',
            'question_21.max' => 'Ukuran file terlalu besar. (maks 2mb)',
        ]);

        $now = new \DateTime('now', new DateTimeZone('Asia/Jakarta'));

        $file[] = array();
        if ($request->file('question_19')) {
            $fileSwab = $request->file('question_19');
            $fileSwabName = Auth::user()->user_name . '_SWAB_' . $now->format('Ymd_His') . '.' .$fileSwab->extension();
            $file['question_19'] = $fileSwabName;
            Storage::putFileAs('uploads', $fileSwab, $fileSwabName);
        } else {
            $file['question_19'] = null;
        }

        if ($request->file('question_20')) {
            $fileLab = $request->file('question_20');
            $fileLabName = Auth::user()->user_name . '_LAB_' . $now->format('Ymd_His') . '.' .$fileLab->extension();
            $file['question_20'] = $fileLabName;
            Storage::putFileAs('uploads', $fileLab, $fileLabName);
        } else {
            $file['question_20'] = null;
        }

        if ($request->file('question_21')) {
            $fileRadiologi = $request->file('question_21');
            $fileRadiologiName = Auth::user()->user_name . '_RADIOLOGI_' . $now->format('Ymd_His') . '.' .$fileRadiologi->extension();
            $file['question_21'] = $fileRadiologiName;
            Storage::putFileAs('uploads', $fileRadiologi, $fileRadiologiName);
        } else {
            $file['question_21'] = null;
        }

        // dd($file);

        $responseId = Response::insertGetId([
            'response_user_id' => $id,
            'response_form_id' => 1,
            'response_status_id' => 1,
            'created_at' => $now->format('Y-m-d H:i:s'),
            'updated_at'=> $now->format('Y-m-d H:i:s'),
        ]);

        $questions = Form::where('forms.id', 1)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get();

        foreach ($questions as $key => $q) {
            if ($q->question_type == 'boolean' || $q->question_type == 'options') {
                $withOptions = true;
            } else {
                $withOptions = false;
            }

            if ($q->question_type == 'options') {
                $ansData = $request->get('question_'.$q->id);

                foreach ($ansData as $key => $ans) {
                    Answer::insert([
                        'answer_user_id' => $id,
                        'answer_response_id' => $responseId,
                        'answer_question_id' => $q->id,
                        'answer_choice_id' => $ans,
                        'answer' => null,
                        'created_at' => $now->format('Y-m-d H:i:s'),
                        'updated_at'=> $now->format('Y-m-d H:i:s'),
                    ]);
                }
            } else if ($q->question_type == 'file') {
                Answer::insert([
                    'answer_user_id' => $id,
                    'answer_response_id' => $responseId,
                    'answer_question_id' => $q->id,
                    'answer_choice_id' => null,
                    'answer' => $file['question_'.$q->id],
                    'created_at' => $now->format('Y-m-d H:i:s'),
                    'updated_at'=> $now->format('Y-m-d H:i:s'),
                ]);
            } else {
                Answer::insert([
                    'answer_user_id' => $id,
                    'answer_response_id' => $responseId,
                    'answer_question_id' => $q->id,
                    'answer_choice_id' => $withOptions ? $request->get('question_'.$q->id) : null,
                    'answer' => !$withOptions ? $request->get('question_'.$q->id) : null,
                    'created_at' => $now->format('Y-m-d H:i:s'),
                    'updated_at'=> $now->format('Y-m-d H:i:s'),
                ]);
            }
        }

        return redirect('/dashboard-pasien');
    }

    public function show($id)
    {
        $userId = Auth::user()->id;
        $response = Response::where('id', $id)->where('response_user_id', $userId)->get();
        if (!count($response)) {
            return redirect('/dashboard-pasien')->withErrors(['error' => 'Anda tidak mempunyai akses']);
        }

        $answers = Answer::where('answer_response_id', $id)
            ->leftJoin('choices', 'choices.id', '=', 'answers.answer_choice_id')->get();

        $questions = Form::where('forms.id', 1)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get();


        $data = array();
        foreach ($questions as $key => $q) {
            $description = $q->question_detail;

            if ($q->question_type == 'options') {
                $answer = array();
            } else {
                $answer = '';
            }

            foreach ($answers as $key => $a) {
                if ($q->id == $a->answer_question_id) {
                    if ($q->question_type == 'options') {
                        array_push($answer, $a->choice);
                    } else if ($q->question_type == 'boolean') {
                        $answer = $a->choice;
                    } else {
                        $answer = $a->answer;
                    }
                }
            }

            if ($q->question_type == 'options') {
                $answer = join(", ", $answer);
            }

            $data[] = [
                'tipe' => $q->question_type,
                'pertanyaan' => $description,
                'jawaban' => $answer
            ];
        }

        // // ??? Data form diagnosa
        // $diagnosa = Result::where('result_response_id', $id)->where('result_form_id', 3)
        //     ->join('responses', 'responses.response_form_id', '=', 'results.result_form_id')->first();

        // $hasilDiagnosa = Answer::where('answer_response_id', $diagnosa->id)
        //     ->leftJoin('choices', 'choices.id', '=', 'answers.answer_choice_id')->get();

        // $questionsDokter = Form::where('forms.id', 3)
        //     ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
        //     ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get();

        // $dataDokter = array();
        // foreach ($questionsDokter as $key => $qD) {
        //     $description = $qD->question_detail;
        //     $answer = '';
        //     foreach ($hasilDiagnosa as $key => $hD) {
        //         if ($qD->id == $hD->answer_question_id) {
        //             $answer = $hD->answer;
        //         }
        //     }

        //     $dataDokter[] = [
        //         'pertanyaan' => $description,
        //         'jawaban' => $answer
        //     ];
        // }

        return view('pasien/detail-keluhan', compact('response', 'data'));
    }
}
