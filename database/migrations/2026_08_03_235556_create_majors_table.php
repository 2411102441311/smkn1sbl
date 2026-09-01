<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel jurusan versi database (menggantikan data statis di MajorController secara bertahap)
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();   // tkj, mp, atp
            $table->string('code')->unique();   // TKJ, MP, ATP
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('capacity')->default(36); // kapasitas kuota per jurusan
            $table->string('icon')->nullable();     // key ikon SVG fallback
            $table->string('logo')->nullable();     // path logo asli kalau sudah diupload
            $table->string('color_from')->nullable();
            $table->string('color_to')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};