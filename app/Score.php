<?php

namespace App;

use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $guarded = [];

    protected $cascadeDeletes = ['scoreSubjects'];

    public function scoreSubjects() 
    {
        return $this->hasMany(ScoreSubject::class);
    }

    public function student() 
    {
        return $this->belongsTo(Student::class);
    }

    public function period() 
    {
        return $this->belongsTo(Period::class);
    }
}
