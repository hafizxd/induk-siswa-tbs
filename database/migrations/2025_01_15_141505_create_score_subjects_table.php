<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('score_id');
            $table->foreignId('subject_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('score_id')->references('id')->on('scores')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score_subjects');
    }
}
