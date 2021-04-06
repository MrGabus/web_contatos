<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ends', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contato_id');
            $table->string('endereco_rua', 50)->default('');
            $table->string('endereco_numero', 5)->default('');
            $table->string('endereco_bairro', 10)->default('');
            $table->string('endereco_cep', 9)->default('');
            $table->string('endereco_estado', 2)->default('');

            $table->timestamps();

            //foreign key de contato
            $table->foreign('contato_id')->references('id')->on('contatos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ends');
    }
}
