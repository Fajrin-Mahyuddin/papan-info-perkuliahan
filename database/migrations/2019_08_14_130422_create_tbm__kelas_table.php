<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbmKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbm_kelas', function (Blueprint $table) {
            $table->increments('id_kelas');
            $table->string('kode');
            $table->string('nama');
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
        Schema::dropIfExists('tbm_kelas');
    }
}
