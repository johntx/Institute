<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
	protected $table = 'careers';
	protected $fillable = ['nombre', 'duracion', 'mes', 'costo'];

	public $timestamps = false;
	
	public function setNombreAttribute($nombre)
	{
		$this->attributes['nombre']=strtoupper($nombre);
	}
}
