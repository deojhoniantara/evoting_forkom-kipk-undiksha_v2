<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->foreignId('agenda_id')->nullable()->after('id')->constrained('agendas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropForeign(['agenda_id']);
            $table->dropColumn('agenda_id');
        });
    }
}; 