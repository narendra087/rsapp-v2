<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Form;
use App\Models\Response;
use App\Models\Question;
use App\Models\QuestionSegment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $response = Response::where('response_user_id', $id)->get();
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
}
