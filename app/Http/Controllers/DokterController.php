<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Form;
use App\Models\Response;
use App\Models\Result;
use App\Models\Answer;
use App\Models\Question;
use App\Models\QuestionSegment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $response = Response::where('responses.response_status_id', 2)
            ->join('answers', 'answers.answer_response_id', '=', 'responses.id')
            ->join('users','users.id','=','responses.response_user_id')
            ->where('answer_question_id', 6)->where('users.user_role_id', 4)->get();

        $perawat = Response::where('responses.response_status_id', 2)->orWhere('responses.response_status_id', 3)
            ->join('results', 'results.result_response_id', '=', 'responses.id')
            ->join('users', 'users.id' , '=', 'results.result_user_id')
            ->where('users.user_role_id', 3)->get();

        $result = Result::where('result_user_id', $id)
            ->join('answers', 'answers.answer_response_id', '=', 'results.result_response_id')
            ->join('users','users.id','=','answers.answer_user_id')
            ->where('answer_question_id', 6)->get();

        // dump($result);
        return view('dokter/dashboard-dokter', compact('response','result', 'perawat'));
    }

    public function create($id)
    {
        // ??? Data form pasien
        $answers = Answer::where('answer_response_id', $id)
            ->leftJoin('choices', 'choices.id', '=', 'answers.answer_choice_id')->get();

        $questions = Form::where('forms.id', 1)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get();

        $dataPasien = array();
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

            $dataPasien[] = [
                'tipe' => $q->question_type,
                'pertanyaan' => $description,
                'jawaban' => $answer
            ];
        }

        // ??? Data form analisa
        // $analisa = Result::where('result_response_id', $id)
        //     ->join('responses', 'responses.response_form_id', '=', 'results.result_form_id')->first();

        // $hasilAnalisa = Answer::where('answer_response_id', $analisa->id)
        //     ->leftJoin('choices', 'choices.id', '=', 'answers.answer_choice_id')->get();

        // $questionsPerawat = Form::where('forms.id', 2)
        //     ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
        //     ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get();

        // $dataPerawat = array();
        // foreach ($questionsPerawat as $key => $qP) {
        //     $description = $qP->question_detail;
        //     $answer = '';
        //     foreach ($hasilAnalisa as $key => $hA) {
        //         if ($qP->id == $hA->answer_question_id) {
        //             $answer = $hA->answer;
        //         }
        //     }

        //     $dataPerawat[] = [
        //         'pertanyaan' => $description,
        //         'jawaban' => $answer
        //     ];
        // }

        // dump($dataPerawat);

        // ??? Data form dokter
        $questionsDokter = Form::where('forms.id', 3)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get();

        $choices = Form::where('forms.id', 3)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')
            ->leftJoin('choices', 'choices.question_id', '=', 'questions.id')->get();

        return view('dokter/form-diagnosa', compact('dataPasien','questionsDokter', 'choices'));
    }

    public function store(Request $request, $id)
    {
        //return $request->all();
        $this->validate($request, [
            'question_26' => ['required'],
            'question_27' => ['required'],
        ],[
            '*.required' => 'Bagian ini diperlukan.',
        ]);

        $userId = Auth::user()->id;
        $now = new \DateTime();

        // $responseId = Response::insertGetId([
        //     'response_user_id' => $userId,
        //     'response_form_id' => 3,
        //     'response_status_id' => 3,
        //     'created_at' => $now->format('Y-m-d H:i:s'),
        //     'updated_at'=> $now->format('Y-m-d H:i:s'),
        // ]);

        Result::insert([
            'result_user_id' => $userId,
            'result_form_id' => 3,
            'result_response_id' => $id,
            'created_at' => $now->format('Y-m-d H:i:s'),
            'updated_at'=> $now->format('Y-m-d H:i:s'),
        ]);

        $questions = Form::where('forms.id', 3)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get();

        foreach ($questions as $key => $qst) {
            Answer::insert([
                'answer_user_id' => $userId,
                'answer_response_id' => $id,
                'answer_question_id' => $qst->id,
                'answer_choice_id' => null,
                'answer' => $request->get('question_'.$qst->id),
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at'=> $now->format('Y-m-d H:i:s'),
            ]);
        }

        $response = Response::find($id);
        $response->response_status_id = 3;
        $response->update();

        return redirect('/dashboard-dokter');
    }
    public function show($id)
    {

        // $response = Response::where('response_user_id', $id)->get();
        // if (!count($response)) {
        //     return redirect('/dashboard-dokter')->withErrors(['error' => 'You don`t have permissions']);
        // }

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
                'pertanyaan' => $description,
                'jawaban' => $answer
            ];
        }

        // Data form diagnosa
        $diagnosa = Result::where('result_response_id', $id)->where('result_form_id', 3)
            ->join('responses', 'responses.response_form_id', '=', 'results.result_form_id')->first();

        $hasilDiagnosa = Answer::where('answer_response_id', $diagnosa->id)
            ->leftJoin('choices', 'choices.id', '=', 'answers.answer_choice_id')->get();

        $questionsDokter = Form::where('forms.id', 3)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get();

        $dataDokter = array();
        foreach ($questionsDokter as $key => $qD) {
            $description = $qD->question_detail;
            $answer = '';
            foreach ($hasilDiagnosa as $key => $hD) {
                if ($qD->id == $hD->answer_question_id) {
                    $answer = $hD->answer;
                }
            }

            $dataDokter[] = [
                'pertanyaan' => $description,
                'jawaban' => $answer
            ];
        }

        return view('dokter/detail-diagnosa', compact('data','dataDokter'));
    }
}
