<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    protected $table = 'quizzes';
    protected $guarded = [];

    use SoftDeletes;

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function user()
    {
            return $this->belongsTo('App\User');
       
    }


}
