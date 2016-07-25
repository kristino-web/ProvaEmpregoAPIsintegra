<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSintegrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sintegras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cnpj');
            $table->string('resultado_json');
            $table->unsignedInteger('idusuario');
            $table->foreign('idusuario')->references('id')->on('users');
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
        Schema::drop('sintegras');
    }
}
