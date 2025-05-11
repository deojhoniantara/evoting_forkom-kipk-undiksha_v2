<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('agendas', function (Blueprint $table) {
            if (Schema::hasColumn('agendas', 'date')) {
                $table->dropColumn('date');
            }
        });
    }
    public function down() {
        Schema::table('agendas', function (Blueprint $table) {
            $table->date('date')->nullable();
        });
    }
}; 