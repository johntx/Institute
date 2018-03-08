<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',100);
            $table->string('detalle',255)->nullable();
            $table->integer('hojas')->nullable();
            $table->decimal('costo',11,2)->nullable();
            $table->decimal('precio',11,2)->nullable();
            $table->integer('stock')->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->integer('career_id')->unsigned()->nullable();
            $table->foreign('career_id')->references('id')->on('careers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('items');
    }
}
