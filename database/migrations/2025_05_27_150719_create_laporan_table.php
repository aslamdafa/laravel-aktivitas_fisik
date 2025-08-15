<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    /**
     * Reverse the migrations.
     */
    public function up()
{
    Schema::create('laporans', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal');
        $table->string('aktivitas');
        $table->enum('intensitas', ['ringan', 'berat']);
        $table->integer('menit');
        $table->time('waktu'); // format: 14:30:00
        $table->timestamps();
    });
}
};
