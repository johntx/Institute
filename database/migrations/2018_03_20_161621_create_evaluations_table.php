<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha')->nullable();
            $table->string('p1',10)->nullable();
            $table->string('p2',10)->nullable();
            $table->string('p3',10)->nullable();
            $table->string('p4',10)->nullable();
            $table->string('p5',10)->nullable();
            $table->string('p6',255)->nullable();
            $table->integer('people_id')->unsigned()->nullable();
            $table->foreign('people_id')->references('id')->on('peoples')->onDelete('cascade');
            $table->integer('inscription_id')->unsigned()->nullable();
            $table->foreign('inscription_id')->references('id')->on('inscriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('evaluations');
    }
}
