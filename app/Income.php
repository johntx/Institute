<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
	protected $table = 'incomes';

	protected $fillable = ['fecha','detalle','total','user_id','office_id'];

	public $timestamps = false;
	public function incomelists()
	{
		return $this->hasMany('Institute\Incomelist');
	}
	public function user()
	{
		return $this->belongsTo('Institute\User');
	}
	public function office()
	{
		return $this->belongsTo('Institute\Office');
	}
}
