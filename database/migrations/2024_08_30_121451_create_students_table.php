<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('abs_9', 20)->nullable();
            $table->string('kelas_9', 20)->nullable();
            $table->string('abs_8', 20)->nullable();
            $table->string('kelas_8', 20)->nullable();
            $table->string('abs_7', 20)->nullable();
            $table->string('kelas_7', 20)->nullable();
            $table->string('tahun_masuk', 4)->nullable();
            $table->string('tahun_mutasi', 4)->nullable();
            $table->string('status_mutasi', 10)->nullable();
            $table->string('status_pendaftar', 20)->nullable();
            $table->string('nomor_test', 20)->nullable();
            $table->string('nisn', 20)->nullable();
            $table->string('nik', 20)->nullable();
            $table->string('nis', 20);
            $table->string('nama_lengkap', 20);
            $table->string('tempat_lahir', 20)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('asal_sekolah', 35)->nullable();
            $table->string('prasekolah', 35)->nullable();
            $table->string('nama_kepala_keluarga', 35)->nullable();
            $table->string('yang_membiayai', 10)->nullable();
            $table->string('kewarganegaraan', 10)->nullable();
            $table->string('jenis_kelamin', 10)->nullable();
            $table->string('agama', 10)->nullable();
            $table->tinyInteger('anak_ke')->nullable();
            $table->tinyInteger('jumlah_saudara')->nullable();
            $table->string('cita_cita', 10)->nullable();
            $table->string('kebutuhan_khusus', 20)->nullable();
            $table->string('nomor_kip', 35)->nullable();
            $table->string('nomor_kk', 35)->nullable();
            $table->string('nomor_hp', 35)->nullable();
            $table->string('pondok_pesantren', 35)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}