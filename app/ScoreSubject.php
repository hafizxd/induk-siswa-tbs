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
        return $this->belongsTo(Score::class);
    }

    public function subject() 
    {
        return $this->belongsTo(Subject::class);
    }

    public function scoreCols() 
    {
        return $this->hasMany(ScoreSubjectCol::class);
    }
}
