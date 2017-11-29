<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeklyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nota',200)->nullable();
            $table->integer('career_id')->unsigned()->nullable();
            $table->foreign('career_id')->references('id')->on('careers')->onDelete('cascade');
            $table->integer('subject_id')->unsigned()->nullable();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('weekly');
    }
}
