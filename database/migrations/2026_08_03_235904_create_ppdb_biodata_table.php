<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb_biodata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->unique()->constrained('ppdb_registrations')->cascadeOnDelete();
            $table->string('nik', 20)->nullable();
            $table->string('name');
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('religion')->nullable();
            $table->text('address')->nullable();
            $table->string('school_origin')->nullable(); // asal sekolah (SMP/MTs)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_biodata');
    }
};