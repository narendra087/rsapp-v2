<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $table = 'results';

    protected $fillable = [
        'result_user_id',
        'result_form_id',
        'result_response_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
