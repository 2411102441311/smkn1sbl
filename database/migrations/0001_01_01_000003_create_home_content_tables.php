<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickers', function (Blueprint $table) {
            $table->id();
            $table->text('text');
        });

        Schema::create('hero_stats', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->string('label');
        });

        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->string('month');
            $table->string('category');
            $table->string('title');
            $table->text('excerpt');
            $table->string('icon');
            $table->string('color');
        });

        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('title');
        });

        Schema::create('prestasi', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('title');
            $table->text('desc');
            $table->string('level');
        });

        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('label');
            $table->string('color');
            $table->string('size')->nullable();
        });

        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->string('month');
            $table->string('title');
            $table->text('desc');
            $table->string('tag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
        Schema::dropIfExists('galeri');
        Schema::dropIfExists('prestasi');
        Schema::dropIfExists('fasilitas');
        Schema::dropIfExists('berita');
        Schema::dropIfExists('hero_stats');
        Schema::dropIfExists('tickers');
    }
};
