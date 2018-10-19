<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestadors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pessoa');
            $table->unsignedInteger('endereco');
            $table->unsignedInteger('telefone');
            $table->unsignedInteger('usuario');
            $table->foreign('pessoa')->references('id')->on('pessoas')->onDelete('cascade');
            $table->foreign('endereco')->references('id')->on('enderecos')->onDelete('cascade');
            $table->foreign('telefone')->references('id')->on('telefones')->onDelete('cascade');
            $table->foreign('usuario')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('prestadors');
    }
}
