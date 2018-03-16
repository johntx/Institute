<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Egress extends Model
{
	protected $table = 'egresses';

	protected $fillable = ['fecha','monto','glosa','nombre','tipo','nit','codigo','user_id','office_id','people_id'];

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
