<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Tickeo extends Model
{
	protected $table = 'tickeos';

	protected $fillable = ['tipo','fecha','biometric_id','dia'];

	public $timestamps = false;
	
	public function biometric()
	{
		return $this->belongsTo('Institute\Biometric');
	}
}
