<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Pilihan jurusan calon siswa, berurutan sesuai prioritas (choice_order 1 = pilihan pertama)
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('major_choices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('ppdb_registrations')->cascadeOnDelete();
            $table->foreignId('major_id')->constrained('majors')->cascadeOnDelete();
            $table->unsignedTinyInteger('choice_order'); // 1, 2, 3, dst
            $table->timestamps();
            $table->unique(['registration_id', 'choice_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('major_choices');
    }
};