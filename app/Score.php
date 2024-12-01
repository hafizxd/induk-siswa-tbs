<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function scoreSubjects() 
    {
        return $this->hasMany(\App\ScoreSubject::class);
    }

    public function student() 
    {
        return $this->belongsTo(Student::class);
    }
}
