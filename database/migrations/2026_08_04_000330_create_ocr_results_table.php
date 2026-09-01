<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Hasil ekstraksi teks/nilai dari foto rapor lewat OCR (Tesseract)
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ocr_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_card_id')->constrained('report_cards')->cascadeOnDelete();
            $table->longText('raw_text')->nullable();       // teks mentah hasil OCR
            $table->json('extracted_data')->nullable();     // hasil parsing nilai per mapel {mapel: nilai}
            $table->decimal('confidence_score', 5, 2)->nullable(); // 0-100, seberapa yakin OCR-nya
            $table->boolean('is_confirmed')->default(false); // sudah dikonfirmasi manual oleh calon siswa/panitia
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ocr_results');
    }
};