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
        Schema::table('candidates', function (Blueprint $table) {
            // Tambahkan kolom baru jika belum ada
            if (!Schema::hasColumn('candidates', 'photo')) {
                $table->string('photo')->nullable()->after('name');
            }
            if (!Schema::hasColumn('candidates', 'vision')) {
                $table->text('vision')->nullable()->after('photo');
            }
            if (!Schema::hasColumn('candidates', 'mission')) {
                $table->text('mission')->nullable()->after('vision');
            }
            if (!Schema::hasColumn('candidates', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('mission');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan
            $columns = ['photo', 'vision', 'mission', 'is_active'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('candidates', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
