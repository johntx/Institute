<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Startclass extends Model
{
	protected $table = 'startclasses';
	protected $fillable = ['fecha_inicio', 'fecha_fin', 'estado', 'career_id', 'office_id', 'duracion', 'descripcion', 'costo'];

	public $timestamps = false;

	public function office()
	{
		return $this->belongsTo('Institute\Office');
	}
	public function career() {
		return $this->belongsTo('Institute\Career');
	}
	public function groups()
	{
		return $this->hasMany('Institute\Group');
	}
	public function startclasses()
	{
		return $this->hasMany('Institute\Startclass');
	}
}
