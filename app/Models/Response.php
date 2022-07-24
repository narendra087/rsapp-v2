<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $table = 'responses';

    protected $fillable = [
        'response_user_id',
        'response_form_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
