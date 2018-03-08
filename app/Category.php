<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';

	protected $fillable = ['nombre'];

	public $timestamps = false;
	public function setNombreAttribute($nombre)
	{
		$this->attributes['nombre']=strtoupper($nombre);
	}
	public function items()
	{
		return $this->hasMany('Institute\Item');
	}
}
