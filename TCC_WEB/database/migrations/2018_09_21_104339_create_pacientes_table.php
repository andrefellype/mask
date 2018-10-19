<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('nascimento');
            $table->string('cpf');
            $table->string('rg');
            $table->unsignedInteger('pessoa');
            $table->unsignedInteger('telefone');
            $table->unsignedInteger('endereco');
            $table->foreign('pessoa')->references('id')->on('pessoas')->onDelete('cascade');
            $table->foreign('telefone')->references('id')->on('telefones')->onDelete('cascade');
            $table->foreign('endereco')->references('id')->on('enderecos')->onDelete('cascade');
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
        Schema::dropIfExists('pacientes');
    }
}
