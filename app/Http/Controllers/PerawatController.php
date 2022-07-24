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

class PerawatController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $response = Response::join('answers', 'answers.answer_response_id', '=', 'responses.id')
            ->join('users','users.id','=','responses.response_user_id')
            ->where('answer_question_id', 7)->get();
        $result = Result::where('result_user_id', $id)
            ->join('answers', 'answers.answer_response_id', '=', 'results.result_response_id')
            ->join('users','users.id','=','answers.answer_user_id')
            ->where('answer_question_id', 7)->get();
        return view('perawat/dashboard-perawat', compact('response','result'));
    }
    public function create($id)
    {
        $segments = Form::where('forms.id', 2)
        ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')->get();

        $questions = Form::where('forms.id', 2)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get();
        
        $choices = Form::where('forms.id', 2)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')
            ->leftJoin('choices', 'choices.question_id', '=', 'questions.id')->get();

        
        return view('perawat/form-analisis', compact('segments','questions','choices'));
    }
    public function update_keluhan($id){
        $answers = Answer::where('answer_response_id', $id)
            ->leftJoin('choices', 'choices.id', '=', 'answers.answer_choice_id')
            ->join('users','users.id','=','answers.answer_user_id')->get();
        
        $questions = Form::where('forms.id', 1)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get();

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
            $choices='';
            return view('perawat/validasi-keluhan', compact('segments', 'questions', 'choices'));
        }
    }
    // public function store(Request $request){
    //     $id = Auth::user()->id;
    //     $this->validate($request,[

    //     ])
    // }
}
