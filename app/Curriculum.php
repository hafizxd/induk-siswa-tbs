<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    public $table = 'curriculums';

    protected $guarded = [];

    public function curriculumScoreCols() {
        return $this->hasMany(CurriculumScoreCol::class, 'curriculum_id', 'id');
    }

    public function periods() {
        return $this->hasMany(Period::class, 'curriculum_id', 'id');
    }
}
