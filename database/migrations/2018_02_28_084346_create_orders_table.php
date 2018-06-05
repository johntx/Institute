<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',200);
            $table->date('fecha_compra')->nullable();
            $table->boolean('recibido')->nullable();
            $table->string('detalle',255)->nullable();
            $table->string('telefono',100)->nullable();
            $table->decimal('subtotal',11,2)->nullable();
            $table->decimal('total',11,2)->nullable();
            $table->decimal('descuento',11,2)->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('office_id')->unsigned()->nullable();
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('set null');
            $table->integer('people_id')->unsigned()->nullable();
            $table->foreign('people_id')->references('id')->on('peoples')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
