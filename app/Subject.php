<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Subject extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $guarded = [];

    protected $cascadeDeletes = ['scoreSubjects'];

    public function scoreSubjects() {
        return $this->hasMany(ScoreSubject::class, 'subject_id', 'id');
    }
}
