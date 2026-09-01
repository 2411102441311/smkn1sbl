<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('primary_color')->default('#2563EB');   // biru muda khas SMK
            $table->string('secondary_color')->default('#60A5FA');
            $table->string('accent_color')->default('#DBEAFE');
            $table->string('hero_image')->nullable();  // foto sekolah utk wallpaper depan
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
