<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('payments', function (Blueprint $table) {
      $table->increments('id');
      $table->date('fecha_pagar')->nullable();
      $table->date('fecha_pago')->nullable();
      $table->string('observacion',255)->nullable();
      $table->string('estado',20)->nullable();
      $table->integer('descuento')->nullable();
      $table->integer('abono')->nullable();
      $table->integer('saldo')->nullable();
      $table->integer('inscription_id')->unsigned()->nullable();
      $table->foreign('inscription_id')->references('id')->on('inscriptions')->onDelete('cascade');
      $table->integer('user_id')->unsigned()->nullable();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
    Schema::drop('payments');
  }
}
