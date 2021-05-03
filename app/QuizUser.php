<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizUser extends Model
{
    protected $table = 'quiz_user';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function quiz() {
        return $this->belongsTo('App\Quiz');
    }

    public function answers() {
        return $this->hasMany('App\Answer');
    }
}
