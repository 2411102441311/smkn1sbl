<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Hasil perhitungan SAW (Simple Additive Weighting) untuk rekomendasi jurusan per pendaftar
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saw_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('ppdb_registrations')->cascadeOnDelete();
            $table->json('criteria_scores');   // skor ternormalisasi per kriteria {kriteria: skor}
            $table->decimal('total_score', 8, 4);
            $table->foreignId('recommended_major_id')->nullable()->constrained('majors')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saw_results');
    }
};