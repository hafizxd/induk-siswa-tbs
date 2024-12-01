<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->enum('type', ['AYAH', 'IBU', 'WALI', 'SISWA']);
            $table->string('nama', 35)->nullable();
            $table->string('status', 35)->nullable();
            $table->string('kewarganegaraan', 35)->nullable();
            $table->string('nik', 35)->nullable();
            $table->string('tempat_lahir', 35)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('pendidikan', 35)->nullable();
            $table->string('pekerjaan', 35)->nullable();
            $table->double('penghasilan')->nullable();
            $table->string('nomor_hp', 15)->nullable();
            $table->string('tinggal_luar_negeri', 35)->nullable();
            $table->string('kepemilikan_rumah', 35)->nullable();
            $table->string('provinsi', 20)->nullable();
            $table->string('kota', 20)->nullable();
            $table->string('kecamatan', 20)->nullable();
            $table->string('desa', 20)->nullable();
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('kode_pos', 8)->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relation_infos');
    }
}
