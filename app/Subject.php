<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function scoreSubjects() {
        return $this->hasMany(ScoreSubject::class, 'subject_id', 'id');
    }
}
