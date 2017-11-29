<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',50)->nullable();
            $table->string('turno',20)->nullable();
            $table->string('estado',20)->nullable();
            $table->integer('career_id')->unsigned()->nullable();
            $table->foreign('career_id')->references('id')->on('careers')->onDelete('set null');
            $table->integer('startclasses_id')->unsigned()->nullable();
            $table->foreign('startclasses_id')->references('id')->on('startclasses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('groups');
    }
}
