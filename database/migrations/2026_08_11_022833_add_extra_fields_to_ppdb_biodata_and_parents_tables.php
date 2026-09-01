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
        Schema::table('ppdb_biodata', function (Blueprint $table) {
            $table->decimal('height_cm', 5, 1)->nullable()->after('gender');   // TB - Tinggi Badan (cm)
            $table->decimal('weight_kg', 5, 1)->nullable()->after('height_cm'); // BB - Berat Badan (kg)
            $table->string('family_card_number', 20)->nullable()->after('nik'); // Nomor KK
            $table->boolean('has_kip')->default(false)->after('family_card_number'); // Punya KIP atau tidak
            $table->string('kip_number', 30)->nullable()->after('has_kip');     // Nomor KIP (kalau ada)
        });
 
        Schema::table('ppdb_parents', function (Blueprint $table) {
            $table->string('father_nik', 20)->nullable()->after('father_name');
            $table->string('mother_nik', 20)->nullable()->after('mother_name');
      
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppdb_biodata_and_parents_tables', function (Blueprint $table) {
            //
        });
    }
};
