<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Form;
use App\Models\Response;
use App\Models\Result;
use App\Models\Answer;
use App\Models\Choice;
use App\Models\Question;
use App\Models\QuestionSegment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DateTimeZone;

class PerawatController extends Controller
{
    // ??? dashboard function
    public function index()
    {
        $response = Response::where('responses.response_status_id', 1)
            ->join('answers', 'answers.answer_response_id', '=', 'responses.id')
            ->join('users','users.id','=','responses.response_user_id')
            ->where('answer_question_id', 6)->where('users.user_role_id', 4)->get(['responses.*','users.user_name', 'answers.answer']);

        $id = Auth::user()->id;
        $result = Result::where('result_user_id', $id)->get();
        $data = array();
        foreach ($result as $key => $res) {
            // ? Get data perawat
            $perawat = User::find($res->result_user_id);
            // ? Get data pasien
            $responses = Response::find($res->result_response_id);
            $pasien = User::find($responses->response_user_id);
            // ? Get data dokter
            $dokterAns = Answer::where('answer_response_id', $responses->id)
                ->whereNotIn('answer_user_id', [$pasien->id, $perawat->id])->first();
            if ($dokterAns) {
                $dokter = User::find($dokterAns->answer_user_id);
            }

            // ? Get data keluhan
            $keluhan = Answer::where('answer_response_id', $responses->id)
                ->where('answer_question_id', 6)->first();

            $data[] = [
                'id' => $res->result_response_id,
                'tanggal' => $res->created_at,
                'pasien' => $pasien->user_name,
                'perawat' => $perawat->user_name,
                'dokter' => $dokterAns ? $dokter->user_name : '-',
                'keluhan' => $keluhan->answer,
                'status' => $responses->response_status_id,
            ];
        }

            // dump($response);
        return view('perawat/dashboard-perawat', compact('response','data'));
    }

    // ??? buat form analisa
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

        // Get data pasien
        $questionsPatient = Form::where('forms.id', 1)
        ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
        ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get();

        $answers = Answer::where('answer_response_id', $id)
            ->leftJoin('choices', 'choices.id', '=', 'answers.answer_choice_id')->get();

        // Insert data question and answer
        $data = array();
        foreach ($questionsPatient as $key => $q) {
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

        return view('perawat/form-analisis', compact('segments','questions','choices', 'data'));
    }

    // ??? simpan form analisa
    public function store(Request $request, $id) {

        $this->validate($request, [
            'question_22' => ['required'],
            'question_23' => ['required'],
            'question_24' => ['required'],
            'question_25' => ['required'],
        ], [
            '*.required' => 'Bagian ini diperlukan.'
        ]);

        $userId = Auth::user()->id;
        $now = new \DateTime('now', new DateTimeZone('Asia/Jakarta'));

        // $responseId = Response::insertGetId([
        //     'response_user_id' => $userId,
        //     'response_form_id' => 2,
        //     'response_status_id' => 1,
        //     'created_at' => $now->format('Y-m-d H:i:s'),
        //     'updated_at'=> $now->format('Y-m-d H:i:s'),
        // ]);

        Result::insert([
            'result_user_id' => $userId,
            'result_form_id' => 2,
            'result_response_id' => $id,
            'created_at' => $now->format('Y-m-d H:i:s'),
            'updated_at'=> $now->format('Y-m-d H:i:s'),
        ]);

        $questions = Form::where('forms.id', 2)
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
        $response->response_status_id = 2;
        $response->update();

        return redirect('/dashboard-perawat');
    }

    // ??? validasi keluhan dan data pasien
    public function validasiKeluhan($id)
    {
        $pasien = Answer::where('answer_response_id', $id)
            ->join('users', 'users.id', '=', 'answers.answer_user_id')->first();

        $segments = Form::where('forms.id', 1)
        ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')->get();

        $questions = Form::where('forms.id', 1)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get();

        $choices = Form::where('forms.id', 1)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')
            ->leftJoin('choices', 'choices.question_id', '=', 'questions.id')->get();

        $answers = Answer::where('answer_response_id', $id)->get();

        foreach ($questions as $key => $question) {
            $arrAnswer = array();
            for ($i=0; $i < count($answers); $i++) {
                if ($question->id == $answers[$i]->answer_question_id) {
                    if ($question->question_type == 'options') {
                        array_push($arrAnswer, $answers[$i]->answer_choice_id);
                    } else if ($question->question_type == 'boolean') {
                        $question['answer'] = $answers[$i]->answer_choice_id;
                        break;
                    } else {
                        $question['answer'] = $answers[$i]->answer;
                        break;
                    }
                }
            }
            if ($question->question_type == 'options') {
                $question['answer'] = $arrAnswer;
            }
        }

        return view('perawat/validasi-keluhan', compact('pasien', 'segments','questions','choices'));
    }

    // !!! vupdate data keluhan pasien (ongoing)
    public function updateKeluhan(Request $request, $id)
    {
        // return $request->all();
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
        ],[
            '*.required' => 'Bagian ini diperlukan.',
            '*.max' => 'Bagian ini tidak boleh melebihi 150 karakter',
            '*.numeric' => 'Bagian ini harus berisi angka.',
            '*.gt' => 'Bagian ini berisi masukan yang tidak valid.'
        ]);

        $now = new \DateTime('now', new DateTimeZone('Asia/Jakarta'));

        $answer = Answer::where('answer_response_id', $id)->first();
        $userId = $answer->answer_user_id;
        $questions = Form::where('forms.id', 1)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get(['questions.*']);

        // return dd($questions);

        foreach ($questions as $key => $q) {
            if ($q->question_type == 'boolean' || $q->question_type == 'options') {
                $withOptions = true;
            } else {
                $withOptions = false;
            }

            if ($q->question_type == 'options') {
                // ??? Delete answer for options question
                Answer::where('answer_response_id', $id)->where('answer_question_id', $q->id)->delete();

                $ansData = $request->get('question_'.$q->id);
                foreach ($ansData as $key => $ans) {
                    Answer::insert([
                        'answer_user_id' => $userId,
                        'answer_response_id' => $id,
                        'answer_question_id' => $q->id,
                        'answer_choice_id' => $ans,
                        'answer' => null,
                        'created_at' => $now->format('Y-m-d H:i:s'),
                        'updated_at'=> $now->format('Y-m-d H:i:s'),
                    ]);
                }
            } else if ($q->question_type != 'file') {
                Answer::where('answer_response_id', $id)->where('answer_question_id', $q->id)->update([
                    'answer_choice_id' => $withOptions ? $request->get('question_'.$q->id) : null,
                    'answer' => !$withOptions ? $request->get('question_'.$q->id) : null,
                    'updated_at'=> $now->format('Y-m-d H:i:s'),
                ]);
            }
        }

        return redirect()->back()->with('updated','Data assessment telah berhasil diperbarui.');
    }

    // ??? update data pasien
    public function updatePasien(Request $request, $pasienId)
    {
        $user = User::find($pasienId);

        $this->validate($request, [
            'name' => ['required', 'max:50'],
            'birthday' => ['required'],
            'phone' => ['required', 'digits_between:6,12', 'numeric'],
            'address' => ['required'],
        ],[
            'name.required' => 'Nama pasien wajib diisi.',
            'name.max' => 'Nama pasien tidak boleh lebih dari 50 karakter.',
            'address.required' => 'Alamat pasien wajib diisi.',
            'birthday.required' => 'Tanggal lahir pasien wajib diisi.',
            'phone.required' => 'Nomor telepon pasien wajib diisi',
            'phone.numeric' => 'Nomor telepon harus berisi angka.',
            'phone.digits_between' => 'Nomor telepon minimal berisi 6 - 12 angka'
        ]);

        $user->user_name = $request->get('name');
        $user->user_phone = $request->get('phone');
        $user->user_birthday = $request->get('birthday');
        $user->user_address = $request->get('address');
        $user->update();

        return redirect()->back()->with('updated','Data Pasien telah berhasil diperbarui.');
    }

    public function show($id)
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

        // Get data pasien
        $questionsPatient = Form::where('forms.id', 1)
        ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
        ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get();

        $answers = Answer::where('answer_response_id', $id)
            ->leftJoin('choices', 'choices.id', '=', 'answers.answer_choice_id')->get();

        // Insert data question and answer
        $data = array();
        foreach ($questionsPatient as $key => $q) {
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


        $jawaban = Answer::where('answer_response_id', $id)->get();
        foreach ($questions as $key => $question) {
            $arrAnswer = array();
            for ($i=0; $i < count($jawaban); $i++) {
                if ($question->id == $jawaban[$i]->answer_question_id) {
                    if ($question->question_type == 'options') {
                        array_push($arrAnswer, $jawaban[$i]->answer_choice_id);
                    } else if ($question->question_type == 'boolean') {
                        $question['answer'] = $jawaban[$i]->answer_choice_id;
                        break;
                    } else {
                        $question['answer'] = $jawaban[$i]->answer;
                        break;
                    }
                }
            }
            if ($question->question_type == 'options') {
                $question['answer'] = $arrAnswer;
            }
        }

        return view('perawat/update-analisis', compact('segments','questions','choices', 'data'));
    }

    public function update(Request $request, $id)
    {
        // return $request->all();
        $this->validate($request, [
            'question_22' => ['required'],
            'question_23' => ['required'],
            'question_24' => ['required'],
            'question_25' => ['required'],
        ], [
            '*.required' => 'Bagian ini diperlukan.'
        ]);

        $userId = Auth::user()->id;
        $now = new \DateTime('now', new DateTimeZone('Asia/Jakarta'));

        $questions = Form::where('forms.id', 2)
            ->join('question_segments', 'question_segments.form_id', '=', 'forms.id')
            ->join('questions', 'questions.question_segment_id', '=', 'question_segments.id')->get(['questions.*']);

        foreach ($questions as $key => $q) {
            if ($q->question_type == 'boolean' || $q->question_type == 'options') {
                $withOptions = true;
            } else {
                $withOptions = false;
            }

            if ($q->question_type == 'options') {
                // ??? Delete answer for options question
                Answer::where('answer_response_id', $id)->where('answer_question_id', $q->id)->delete();

                $ansData = $request->get('question_'.$q->id);
                foreach ($ansData as $key => $ans) {
                    Answer::insert([
                        'answer_user_id' => $userId,
                        'answer_response_id' => $id,
                        'answer_question_id' => $q->id,
                        'answer_choice_id' => $ans,
                        'answer' => null,
                        'created_at' => $now->format('Y-m-d H:i:s'),
                        'updated_at'=> $now->format('Y-m-d H:i:s'),
                    ]);
                }
            } else if ($q->question_type != 'file') {
                Answer::where('answer_response_id', $id)->where('answer_question_id', $q->id)->update([
                    'answer_choice_id' => $withOptions ? $request->get('question_'.$q->id) : null,
                    'answer' => !$withOptions ? $request->get('question_'.$q->id) : null,
                    'updated_at'=> $now->format('Y-m-d H:i:s'),
                ]);
            }
        }

        return redirect()->back()->with('updated','Data analisa telah berhasil diperbarui.');
    }

    public function detail($responseId)
    {
        $userId = Auth::user()->id;
        $result = Result::where('result_response_id', $responseId)->first();
        if ($result->result_user_id != $userId) {
            return redirect()->back()->withErrors(['error' => 'Anda tidak mempunyai akses']);
        }

        $response = Response::find($responseId);
        $answers = Answer::where('answer_response_id', $responseId)->get();
        $questions = Question::get();

        $dataPasien = array();
        $dataPerawat = array();
        $dataDokter = array();
        foreach ($questions as $key => $question) {
            if ($question->question_type == 'boolean') {
                $answer = Answer::where('answer_response_id', $responseId)->where('answer_question_id', $question->id)->first();
                $choice = Choice::find($answer->answer_choice_id);
                $jawaban = $choice->choice;
            } else if ($question->question_type == 'options') {
                $answer = Answer::where('answer_response_id', $responseId)->where('answer_question_id', $question->id)->get();
                $arrAnswer = array();
                foreach ($answer as $key => $ans) {
                    $choice = Choice::find($ans->answer_choice_id);
                    array_push($arrAnswer, $choice->choice);
                }
                $jawaban = join(", ", $arrAnswer);
            } else {
                $answer = Answer::where('answer_response_id', $responseId)->where('answer_question_id', $question->id)->first();
                if ($answer) {
                    $jawaban = $answer->answer;
                } else {
                    $jawaban = '';
                }
            }

            // ? Pasien answer
            $temp = Answer::where('answer_response_id', $responseId)->where('answer_question_id', $question->id)->first();
            if ($temp) {
                if ($temp->answer_user_id == $response->response_user_id) {
                    $dataPasien[] = [
                        'tipe' => $question->question_type,
                        'pertanyaan' => $question->question_detail,
                        'jawaban' => $jawaban,
                    ];
                // ? Perawat answer
                } else if ($temp->answer_user_id == $userId) {
                    $dataPerawat[] = [
                        'tipe' => $question->question_type,
                        'pertanyaan' => $question->question_detail,
                        'jawaban' => $jawaban,
                    ];
                // ? Dokter answer
                } else {
                    $dataDokter[] = [
                        'tipe' => $question->question_type,
                        'pertanyaan' => $question->question_detail,
                        'jawaban' => $jawaban,
                    ];
                }
            }
        }

        return view('perawat/detail-analisis', compact('dataPasien','dataPerawat','dataDokter'));
    }
}
