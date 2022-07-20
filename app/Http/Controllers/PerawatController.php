<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Form;
use App\Models\Response;
use App\Models\Question;
use App\Models\QuestionSegment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PerawatController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $response = Response::where('response_user_id', $id)->get();
        return view('perawat/dashboard-perawat', compact('response'));
    }
    public function create()
    {
        $id = Auth::user()->id;
        $answers = Answers::
        $questions = Form::where('forms.id', 2)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')
            ->leftJoin('choices', 'choices.question_id', '=', 'questions.id')->get();
        dump($questions);
        return view('perawat/form-perawat', compact('questions'));
    }
}
