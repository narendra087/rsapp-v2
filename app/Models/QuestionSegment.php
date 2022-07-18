<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionSegment extends Model
{
    use HasFactory;

    protected $table = 'question_segments';

    protected $fillable = [
        'form_id',
        'question_segment',
        'question_segment_desc',
        'question_segment_status'
    ];
}
