<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $table = 'forms';

    protected $fillable = [
        'form_name',
    ];

    public function response()
    {
        return $this->hasMany('App\Models\Response');
    }

    public function segment()
    {
        return $this->hasMany('App\Models\QuestionSegment');
    }

    public function question()
    {
        return $this->hasMany('App\Models\Question');
    }
}
