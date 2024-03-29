<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    
    protected $guarded = [];

    public function question() {
        return $this->belongsTo('App\Question');
    }

    public function choice() {
        return $this->belongsTo('App\Choice');
    }
}
