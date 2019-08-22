<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbdJadwalKuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbd_jadwal_kuliah', function (Blueprint $table) {
            $table->increments('id_jadwal');
            $table->integer('id_dosen')->unsigned()->nullable();
            $table->foreign('id_dosen')->references('id_dosen')->on('tbd_dosen')->onDelete('set null');
            $table->integer('id_mk')->unsigned();
            $table->foreign('id_mk')->references('id_mk')->on('tbm_mata_kuliah')->onDelete('cascade');
            $table->integer('id_kelas')->unsigned()->nullable();
            $table->foreign('id_kelas')->references('id_kelas')->on('tbm_kelas')->onDelete('set null');
            $table->integer('id_semester')->unsigned();
            $table->foreign('id_semester')->references('id_semester')->on('tb_semester')->onDelete('cascade');
            $table->string('hari');
            $table->time('jam_mulai');
            $table->time('jam_akhir');
            $table->string('status');
            $table->string('ket');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbd_jadwal_kuliah');
    }
}
