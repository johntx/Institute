<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
	protected $table = 'careers';
	protected $fillable = ['nombre', 'color', 'texto'];

	public $timestamps = false;
	
	public function setNombreAttribute($nombre)
	{
		$this->attributes['nombre']=strtoupper($nombre);
	}
	public function startclasses()
	{
		return $this->hasMany('Institute\Startclass');
	}
	public function items()
	{
		return $this->hasMany('Institute\Item');
	}
	public function tests()
	{
		return $this->hasMany('Institute\Test');
	}
	public function subjects() {
		return $this->belongsToMany('Institute\Subject','weekly');
	}
}
