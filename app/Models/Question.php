<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
        'question_segment_id',
        'question_detail',
        'question_desc',
        'question_type',
        'question_required',
        'question_disabled'
    ];

    public function segment()
    {
        return $this->hasOne('App\Models\QuestionSegment');
    }

    public function choice()
    {
        return $this->hasMany('App\Models\Choice');
    }
}
