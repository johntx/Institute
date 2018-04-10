<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Biometric extends Model
{
	protected $table = 'biometrics';

	protected $fillable = ['id','nombre'];

	public $timestamps = false;
}
