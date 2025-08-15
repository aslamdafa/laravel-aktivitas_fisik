<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            // 1. Tambahkan kolom user_id terlebih dahulu
            if (!Schema::hasColumn('laporans', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id'); // atau after kolom tertentu
            }

            // 2. Tambahkan foreign key constraint
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};

