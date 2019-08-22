<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbdInformasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbd_informasi', function (Blueprint $table) {
            $table->increments('id_informasi');
            $table->integer('id_dosen')->unsigned()->nullable();
            $table->foreign('id_dosen')->references('id_dosen')->on('tbd_dosen')->onDelete('set null');
            $table->integer('id_semester')->unsigned();
            $table->foreign('id_semester')->references('id_semester')->on('tb_semester')->onDelete('cascade');
            $table->string('judul');
            $table->text('isi_informasi');
            $table->string('ket');
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
        Schema::dropIfExists('tbd_informasi');
    }
}
