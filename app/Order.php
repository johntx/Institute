<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table = 'orders';

	protected $fillable = ['nombre','fecha_compra','detalle','telefono','subtotal','total','descuento','user_id','office_id','people_id'];

	public $timestamps = false;
	public function setNombreAttribute($nombre)
	{
		$this->attributes['nombre']=strtoupper($nombre);
	}
	public function buylists()
	{
		return $this->hasMany('Institute\Buylist');
	}
	public function user()
	{
		return $this->belongsTo('Institute\User');
	}
	public function office()
	{
		return $this->belongsTo('Institute\Office');
	}
	public function people()
	{
		return $this->belongsTo('Institute\People');
	}
}
