<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPosKelasSiswaId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->bigInteger('pos_kelas_siswa_id')->unsigned()->after('id');
            $table->foreign('pos_kelas_siswa_id')->references('id')->on('pos_kelas_siswa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropForeign('pembayaran_pos_kelas_siswa_id_foreign');
            $table->dropColumn('pos_kelas_siswa_id');
        });
    }
}
