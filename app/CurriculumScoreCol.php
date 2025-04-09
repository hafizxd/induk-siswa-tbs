<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurriculumScoreCol extends Model
{
    public $table = "curriculum_score_cols";

    protected $guarded = [];

    public function curriculum() {
        return $this->belongsTo(Curriculum::class);
    }

    public function scoreCols() {
        return $this->hasMany(ScoreSubjectCol::class);
    }
}
