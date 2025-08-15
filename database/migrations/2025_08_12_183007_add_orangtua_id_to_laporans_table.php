<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrangtuaIdToLaporansTable extends Migration
{
    public function up()
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->unsignedBigInteger('orangtua_id')->nullable()->after('id');

            // Pastikan users.id adalah unsignedBigInteger
            $table->foreign('orangtua_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropForeign(['orangtua_id']);
            $table->dropColumn('orangtua_id');
        });
    }
}
