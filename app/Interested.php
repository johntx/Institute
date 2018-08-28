<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Interested extends Model
{
	protected $table = 'interesteds';
	protected $fillable = ['nombre', 'telefono', 'fecha', 'enviado', 'career_id', 'user_id'];

	public $timestamps = false;

	public function career() {
		return $this->belongsTo('Institute\Career');
	}
	public function user() {
		return $this->belongsTo('Institute\User');
	}
}
