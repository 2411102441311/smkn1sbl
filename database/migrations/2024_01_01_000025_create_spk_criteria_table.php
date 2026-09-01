<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spk_criteria', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();  // C1, C2, ...
            $table->string('name');
            $table->enum('type', ['benefit', 'cost'])->default('benefit');
            $table->decimal('weight', 5, 4)->default(0); // bobot kriteria (SAW/WP/dll)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spk_criteria');
    }
};
