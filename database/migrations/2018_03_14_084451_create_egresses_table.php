<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egresses', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha')->nullable();
            $table->decimal('monto',11,2)->nullable();
            $table->decimal('descuento',11,2)->nullable();
            $table->string('glosa',200)->nullable();
            $table->string('tipo',25)->nullable();
            $table->string('nit',20)->nullable();
            $table->string('codigo',20)->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('office_id')->unsigned()->nullable();
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('set null');
            $table->integer('people_id')->unsigned()->nullable();
            $table->foreign('people_id')->references('id')->on('peoples')->onDelete('cascade');
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
        Schema::drop('egresses');
    }
}
