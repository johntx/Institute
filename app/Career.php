<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
	protected $table = 'careers';
	protected $fillable = ['nombre', 'duracion', 'mes', 'costo', 'office_id'];

	public $timestamps = false;
	
	public function office()
	{
		return $this->belongsTo('Institute\Office');
	}
	public function setNombreAttribute($nombre)
	{
		$this->attributes['nombre']=strtoupper($nombre);
	}
	public function startclasses()
	{
		return $this->hasMany('Institute\Startclass');
	}
}
