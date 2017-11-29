<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
	protected $table = 'offices';

	protected $fillable = ['nombre','direccion'];

	public $timestamps = false;
}
