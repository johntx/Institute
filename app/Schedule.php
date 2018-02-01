<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
	protected $table = 'schedules';

	protected $fillable = ['descripcion','vigente','fecha'];

	public $timestamps = false;
	
	public function hours()
	{
		return $this->hasMany('Institute\Hour');
	}
}
