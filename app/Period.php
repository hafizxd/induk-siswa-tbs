<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    public $table = 'periods';

    protected $guarded = [];

    public function curriculum() {
        return $this->belongsTo(Curriculum::class);
    }

    public function subjects() {
        return $this->belongsToMany(Subject::class, 'period_subjects');
    }

    public function scores() {
        return $this->hasMany(Score::class);
    }
}
