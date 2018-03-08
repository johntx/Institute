<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	protected $table = 'items';

	protected $fillable = ['nombre','detalle','hojas','precio','costo','stock','category_id','career_id'];

	public $timestamps = false;
	public function setNombreAttribute($nombre)
	{
		$this->attributes['nombre']=strtoupper($nombre);
	}
	public function orders()
	{
		return $this->hasMany('Institute\Order');
	}
	public function category()
	{
		return $this->belongsTo('Institute\Category');
	}
	public function career()
	{
		return $this->belongsTo('Institute\Career');
	}
}
