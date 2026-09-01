<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultation_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('knowledge_base_id')->constrained()->cascadeOnDelete();
            $table->decimal('cf_final', 5, 4);  // hasil akhir CF combine
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultation_results');
    }
};
