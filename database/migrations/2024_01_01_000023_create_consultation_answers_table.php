<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultation_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->decimal('cf_user', 4, 2)->default(0); // keyakinan user thd gejala
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultation_answers');
    }
};
