<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Startclasses extends Model
{
	protected $table = 'startclasses';
	protected $fillable = ['fecha', 'career_id'];

	public $timestamps = false;

	public function career() {
		return $this->belongsTo('Institute\Career');
	}
}
