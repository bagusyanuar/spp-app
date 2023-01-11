<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosPembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tahun_ajaran_id')->unsigned();
            $table->bigInteger('kelas_id')->unsigned();
            $table->bigInteger('jenis_pembayaran_id')->unsigned();
            $table->integer('nominal')->default(0);
            $table->timestamps();
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajaran');
            $table->foreign('kelas_id')->references('id')->on('kelas');
            $table->foreign('jenis_pembayaran_id')->references('id')->on('jenis_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pos_pembayaran');
    }
}
