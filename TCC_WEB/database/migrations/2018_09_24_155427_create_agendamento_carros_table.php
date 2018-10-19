<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendamentoCarrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamento_carros', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('data');
            $table->text('observacao')->nullable();
            $table->unsignedInteger('vaga');
            $table->unsignedInteger('carro');
            $table->unsignedInteger('motorista');
            $table->foreign('vaga')->references('id')->on('vagas')->onDelete('cascade');
            $table->foreign('carro')->references('id')->on('carros')->onDelete('cascade');
            $table->foreign('motorista')->references('id')->on('motoristas')->onDelete('cascade');
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
        Schema::dropIfExists('agendamento_carros');
    }
}
