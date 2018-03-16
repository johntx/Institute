<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
	protected $table = 'ingreso';

	protected $fillable = ['ingreso','egreso','fecha','fin','total'];

	public $timestamps = false;
}
