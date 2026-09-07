<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Nullable: foto galeri boleh gak ditandain jurusan apapun (tetap tampil di galeri umum homepage).
            // Isinya slug jurusan (tkj/mp/atp), dicocokkan ke MajorController::data(), bukan foreign key
            // ke tabel database karena data jurusan masih statis di kode, bukan di tabel tersendiri.
            $table->string('major_slug')->nullable()->after('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('major_slug');
        });
    }
};