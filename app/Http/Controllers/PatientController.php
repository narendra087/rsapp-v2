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
        // $requests =  $request->all();
        $id = Auth::user()->id;

        $this->validate($request, [
            '0' => ['nullable'],
            'question_1' => ['required'],
            'question_2' => ['required', 'max:50'],
            'question_3' => ['required'],
            'question_4' => ['required'],
            'question_5' => ['required', 'max:50'],
            'question_6' => ['required', 'max:50'],
            'question_7' => ['required', 'max:50'],
            'question_8' => ['nullable'],
            'question_9' => ['nullable'],
            'question_10' => ['nullable'],
            'question_11' => ['nullable'],
            'question_12' => ['nullable'],
            'question_13' => ['nullable', 'numeric'],
            'question_14' => ['nullable', 'numeric'],
            'question_15' => ['nullable', 'numeric'],
            'question_16' => ['nullable', 'numeric'],
            'question_17' => ['nullable', 'numeric'],
            'question_18' => ['nullable'],
            'question_19' => ['nullable'],
            'question_20' => ['nullable'],
        ]);

        $now = new \DateTime();

        $responseId = Response::insertGetId([
            'response_user_id' => $id,
            'response_form_id' => 1,
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
}
