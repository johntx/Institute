<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Incomelist extends Model
{
	protected $table = 'incomelists';

	protected $fillable = ['cantidad','item_id','income_id'];

	public $timestamps = false;
	public function item()
	{
		return $this->belongsTo('Institute\Item');
	}
	public function income()
	{
		return $this->belongsTo('Institute\Income');
	}
}
