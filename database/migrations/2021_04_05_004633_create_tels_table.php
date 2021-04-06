<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contato_id');
            $table->string('telefone', 30)->default('');                      

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
        Schema::dropIfExists('tels');
    }
}
