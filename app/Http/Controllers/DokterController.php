<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Form;
use App\Models\Response;
use App\Models\Question;
use App\Models\QuestionSegment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $response = Response::where('response_user_id', $id)->get();
        return view('dokter/dashboard-dokter', compact('response'));
    }
    public function create($id)
    {
        $id = Auth::user()->id;
        $userId = Auth::user()->id;
        $response = Response::where('id', $id)->where('response_user_id', $userId)->get();
        if (!count($response)) {
            return redirect('/dashboard-pasien')->withErrors(['error' => 'You don`t have permissions']);
        }

        $answers = Answer::where('answer_response_id', $id)
            ->leftJoin('choices', 'choices.id', '=', 'answers.answer_choice_id')->get();

        $questions = Form::where('forms.id', 1)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get();

        $questionsDokter = Form::where('forms.id', 3)
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

        $diagnosa = '';
        
        return view('dokter/form-diagnosa', compact('response', 'data', 'diagnosa','questionDokter'));
    }
}
