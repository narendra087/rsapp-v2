<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $table = 'answers';

    protected $fillable = [
        'answer_user_id',
        'answer_response_id',
        'answer_question_id',
        'answer_choice_id',
        'answer'	
    ];

    public function user()
    {
        return $this->hasMany('App\Models\User');
    }
    public function question()
    {
        return $this->hasMany('App\Models\Question');
    }
    public function response()
    {
        return $this->hasMany('App\Models\Response');
    }
    public function choice()
    {
        return $this->hasMany('App\Models\Choice');
    }
    
}
