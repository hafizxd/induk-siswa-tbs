<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScoreSubjectCol extends Model
{
    protected $guarded = [];

    public function scoreSubject() {
        return $this->belongsTo(ScoreSubject::class);
    }

    public function curriculumCol() {
        return $this->belongsTo(CurriculumScoreCol::class);
    }
}
