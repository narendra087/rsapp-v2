<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\User;
use App\Models\Form;
use App\Models\Response;
use App\Models\Question;
use App\Models\QuestionSegment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    public function store(Request $request)
    {
        // return $request->all();
        $id = Auth::user()->id;
        $data = request()->validate([
            '0' => ['nullable'],
            '1' => ['required'],
            '2' => ['required', 'max:50'],
            '3' => ['required'],
            '4' => ['required'],
            '5' => ['required', 'max:50'],
            '6' => ['required', 'max:50'],
            '7' => ['required', 'max:50'],
            '8' => ['nullable'],
            '9' => ['nullable'],
            '10' => ['nullable'],
            '11' => ['nullable'],
            '12' => ['nullable'],
            '13' => ['nullable', 'numeric'],
            '14' => ['nullable', 'numeric'],
            '15' => ['nullable', 'numeric'],
            '16' => ['nullable', 'numeric'],
            '17' => ['nullable', 'numeric'],
            '18' => ['nullable'],
            '19' => ['nullable'],
            '20' => ['nullable'],
        ]);

        $now = new \DateTime();

        $responseId = Response::insertGetId([
            'response_user_id' => $id,
            'response_form_id' => 1,
            'created_at' => $now->format('Y-m-d H:i:s'),
            'updated_at'=> $now->format('Y-m-d H:i:s'),
        ]);

        Answer::insert([
            'answer_user_id' => $id,
            'answer_response_id' => $responseId,
            'answer_question_id' => 1,
            'answer_choice_id' => 1,
            'answer' => null,
            'created_at' => $now->format('Y-m-d H:i:s'),
            'updated_at'=> $now->format('Y-m-d H:i:s'),
        ]);

        return redirect('/dashboard-pasien');
    }
}
