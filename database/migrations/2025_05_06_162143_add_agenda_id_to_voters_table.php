<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgendaIdToVotersTable extends Migration
{
    public function up()
    {
        Schema::table('voters', function (Blueprint $table) {
            $table->unsignedBigInteger('agenda_id')->after('id')->nullable(false); // Tambahkan kolom agenda_id
            $table->foreign('agenda_id')->references('id')->on('agendas')->onDelete('cascade'); // Tambahkan foreign key
        });
    }

    public function down()
    {
        Schema::table('voters', function (Blueprint $table) {
            $table->dropForeign(['agenda_id']); // Hapus foreign key
            $table->dropColumn('agenda_id'); // Hapus kolom agenda_id
        });
    }
}
