<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spk_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alternative_id')->constrained('spk_alternatives')->cascadeOnDelete();
            $table->foreignId('criteria_id')->constrained('spk_criteria')->cascadeOnDelete();
            $table->decimal('value', 10, 2); // nilai mentah alternatif thd kriteria
            $table->timestamps();
            $table->unique(['alternative_id', 'criteria_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spk_evaluations');
    }
};
