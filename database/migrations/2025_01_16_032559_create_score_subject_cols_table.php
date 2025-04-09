<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreSubjectColsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_subject_cols', function (Blueprint $table) {
            $table->id();
            $table->foreignId('score_subject_id')->constrained('score_subjects')->onDelete('cascade');
            $table->foreignId('curriculum_col_id')->constrained('curriculum_score_cols')->onDelete('cascade');
            $table->float('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score_subject_cols');
    }
}
