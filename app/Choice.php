<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Choice extends Model
{
    protected $guarded = [];
    
    use SoftDeletes;

    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}
