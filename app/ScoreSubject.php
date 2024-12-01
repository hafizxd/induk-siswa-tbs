<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScoreSubject extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function score() 
    {
        return $this->belongsTo(\App\Score::class);
    }

    public function subject() 
    {
        return $this->belongsTo(\App\Subject::class);
    }
}
