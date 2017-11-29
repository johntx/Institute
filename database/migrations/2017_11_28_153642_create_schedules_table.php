<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('semana')->nullable();
            $table->integer('hour_id')->unsigned()->nullable();
            $table->foreign('hour_id')->references('id')->on('hours')->onDelete('set null');
            $table->integer('classroom_id')->unsigned()->nullable();
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('set null');
            $table->integer('subject_id')->unsigned()->nullable();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null');
            $table->integer('career_id')->unsigned()->nullable();
            $table->foreign('career_id')->references('id')->on('careers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('schedules');
    }
}
