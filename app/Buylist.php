<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Buylist extends Model
{
	protected $table = 'buylists';

	protected $fillable = ['cantidad','descuento','item_id','order_id'];

	public $timestamps = false;
	public function item()
	{
		return $this->belongsTo('Institute\Item');
	}
	public function order()
	{
		return $this->belongsTo('Institute\Order');
	}
}
