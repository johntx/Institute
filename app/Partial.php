<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Partial extends Model
{
	protected $table = 'partials';
	protected $fillable = ['nombre'];

	public $timestamps = false;
}
