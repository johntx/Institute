<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Available extends Model
{
	protected $table = 'availables';

	protected $fillable = ['id','lunes','martes','miercoles','jueves','viernes','sabado','people_id'];
	public $timestamps = false;
	
	public function people()
	{
		return $this->belongsTo('Institute\People');
	}
}
