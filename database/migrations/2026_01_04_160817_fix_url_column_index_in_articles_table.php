<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {

            // 1️⃣ HAPUS UNIQUE INDEX
            $table->dropUnique(['url']);

            // 2️⃣ UBAH KOLOM JADI TEXT
            $table->text('url')->change();
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {

            // 3️⃣ BALIK KE STRING + UNIQUE (kalau rollback)
            $table->string('url', 255)->unique()->change();
        });
    }
};
