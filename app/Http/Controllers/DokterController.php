<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Form;
use App\Models\Response;
use App\Models\Result;
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
            ->where('answer_question_id', 7)->where('users.user_role_id', 4)->get();

        $perawat = Response::where('responses.response_status_id', [2, 3])
            ->join('results', 'results.result_response_id', '=', 'responses.id')
            ->join('users', 'users.id' , '=', 'results.result_user_id')->get();

        $result = Result::where('result_user_id', $id)
            ->join('answers', 'answers.answer_response_id', '=', 'results.result_response_id')
            ->join('users','users.id','=','answers.answer_user_id')
            ->where('answer_question_id', 7)->get();

        // dump($perawat, $response);
        return view('dokter/dashboard-dokter', compact('response','result', 'perawat'));
    }

    public function create(Request $request)
    {
        $id = Auth::user()->id;
        // $response = Response::where('response_user_id', $request->get('id'))
        //     ->join('answers','answers.answer_response_id','=','responses.id')->get();
        $questions = Form::where('forms.id', 3)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get();
        return view('dokter/form-diagnosa', compact('questions'));
    }
}
