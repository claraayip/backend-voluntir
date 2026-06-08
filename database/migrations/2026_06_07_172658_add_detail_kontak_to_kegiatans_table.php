<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kegiatans', function (Blueprint $table) {

            $table->string('nama_penanggung_jawab')->nullable();

            $table->string('telepon')->nullable();

            $table->string('email_kontak')->nullable();

            $table->time('jam')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('kegiatans', function (Blueprint $table) {

            $table->dropColumn([
                'nama_penanggung_jawab',
                'telepon',
                'email_kontak',
                'jam'
            ]);

        });
    }
};