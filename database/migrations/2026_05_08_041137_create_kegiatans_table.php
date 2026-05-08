<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();

            $table->string('nama_kegiatan');
            $table->text('deskripsi');
            $table->string('lokasi');
            $table->date('tanggal');
            $table->string('kategori');
            $table->string('durasi');

            $table->integer('kuota');

            $table->string('gambar')->nullable();

            $table->string('status')->default('tersedia');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};