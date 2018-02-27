<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InscriptionsExtras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscriptions_extras', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inscription_id')->unsigned();
            $table->foreign('inscription_id')->references('id')->on('inscriptions')->onDelete('cascade');
            $table->integer('extra_id')->unsigned();
            $table->foreign('extra_id')->references('id')->on('extras')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inscriptions_extras');
    }
}
