<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('lokasi');
            $table->enum('jenis', ['gratis', 'berbayar']);
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->unsignedInteger('kuota');
            $table->boolean('mengeluarkan_sertifikat')->default(false);
            $table->string('image')->nullable(); // untuk menyimpan path gambar
            $table->json('form_pendaftaran')->nullable(); // untuk custom form peserta
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
