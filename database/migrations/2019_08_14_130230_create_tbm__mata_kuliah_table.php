<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbmMataKuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbm_mata_kuliah', function (Blueprint $table) {
            $table->increments('id_mk');
            $table->string('kode');
            $table->string('nama');
            $table->bigInteger('sks');
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
        Schema::dropIfExists('tbm_mata_kuliah');
    }
}
