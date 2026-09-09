<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppdb_parents', function (Blueprint $table) {
            $table->boolean('has_guardian')
                ->default(false)
                ->after('registration_id');

            $table->string('guardian_relationship', 50)
                ->nullable()
                ->after('has_guardian');

            $table->string('guardian_name', 255)
                ->nullable()
                ->after('guardian_relationship');

            $table->string('guardian_nik', 20)
                ->nullable()
                ->after('guardian_name');

            $table->string('guardian_phone', 30)
                ->nullable()
                ->after('guardian_nik');

            $table->string('guardian_occupation', 100)
                ->nullable()
                ->after('guardian_phone');
        });
    }

    public function down(): void
    {
        Schema::table('ppdb_parents', function (Blueprint $table) {
            $table->dropColumn([
                'has_guardian',
                'guardian_relationship',
                'guardian_name',
                'guardian_nik',
                'guardian_phone',
                'guardian_occupation',
            ]);
        });
    }
};