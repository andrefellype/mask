<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendamentoPacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamento_pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('data');
            $table->text('observacao')->nullable();
            $table->unsignedInteger('vaga');
            $table->unsignedInteger('paciente');
            $table->foreign('vaga')->references('id')->on('vagas')->onDelete('cascade');
            $table->foreign('paciente')->references('id')->on('pacientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendamento_pacientes');
    }
}
