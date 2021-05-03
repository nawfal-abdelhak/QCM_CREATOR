<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    protected $guarded = [];
    
    use SoftDeletes;

    public function quiz()
    {
        return $this->belongsTo('App\Quiz');
    }

    public function choices()
    {
        return $this->hasMany('App\Choice');
    }

    public function getImageAttribute($value) {
        return $value? url($value) : $value;
    }
}
