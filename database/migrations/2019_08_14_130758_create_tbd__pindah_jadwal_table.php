<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbdPindahJadwalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbd_pindah_jadwal', function (Blueprint $table) {
            $table->increments('id_pindah');
            $table->integer('id_jadwal')->unsigned();
            $table->string('kode_pindah');
            $table->foreign('id_jadwal')->references('id_jadwal')->on('tbd_jadwal_kuliah')->onDelete('cascade');
            $table->integer('id_kelas')->unsigned()->nullable();
            $table->foreign('id_kelas')->references('id_kelas')->on('tbm_kelas')->onDelete('set null');
            $table->string('hari_pindah');
            $table->time('jam_mulai_pindah');
            $table->time('jam_akhir_pindah');
            $table->dateTime('tgl_pindah');
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
        Schema::dropIfExists('tbd_pindah_jadwal');
    }
}
