<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNisSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('nis')->after('id')->unique();
            $table->smallInteger('status')->default(0)->after('alamat');
            $table->string('ibu')->after('status');
            $table->string('ayah')->after('ibu');
            $table->string('no_hp_ortu')->after('ayah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn('nis');
            $table->dropColumn('status');
            $table->dropColumn('ibu');
            $table->dropColumn('ayah');
            $table->dropColumn('no_hp_ortu');
        });
    }
}
