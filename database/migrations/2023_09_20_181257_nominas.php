<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Nominas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('nominas',function(Blueprint $table){

            $table->increments('idn');
            $table->date('fecha');
            $table->string('monto',10);
            $table->string('diast',10);
            $table->integer('ide')->unsigned();
            $table->foreign('ide')->references('ide')->on('empleados');

            $table->rememberToken();
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
        //
        Schema::drop('nominas');
    }
}
