<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', [
                'draft',            // masih diisi calon siswa
                'submitted',        // sudah dikirim, menunggu verifikasi
                'documents_valid',  // berkas terverifikasi
                'documents_invalid',// berkas ditolak, perlu revisi
                'graded',           // nilai rapor sudah diproses OCR
                'recommended',      // sudah dapat rekomendasi jurusan (SAW)
                'accepted',         // diterima
                'rejected',         // ditolak
            ])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_registrations');
    }
};