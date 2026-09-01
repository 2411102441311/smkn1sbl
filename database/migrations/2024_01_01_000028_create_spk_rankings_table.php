<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spk_rankings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alternative_id')->constrained('spk_alternatives')->cascadeOnDelete();
            $table->decimal('final_score', 10, 4);
            $table->unsignedInteger('rank_position');
            $table->string('method')->default('SAW'); // SAW, WP, TOPSIS, dll
            $table->timestamp('calculated_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spk_rankings');
    }
};
