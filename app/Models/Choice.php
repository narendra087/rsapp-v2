<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $table = 'choices';

    protected $fillable = [
        'question_id',
        'choice',
        'choice_other',
        'choice_default',
        'choice_status'
    ];
}
