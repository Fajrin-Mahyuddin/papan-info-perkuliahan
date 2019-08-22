<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbdDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbd_dosen', function (Blueprint $table) {
            $table->increments('id_dosen');
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->string('nama');
            $table->string('nip');
            $table->string('no_hp');
            $table->string('jabatan');
            $table->text('alamat');
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
        Schema::dropIfExists('tbd_dosen');
    }
}
