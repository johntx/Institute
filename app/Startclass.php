<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Startclass extends Model
{
	protected $table = 'startclasses';
	protected $fillable = ['fecha_inicio', 'fecha_fin', 'estado', 'career_id'];

	public $timestamps = false;

	public function career() {
		return $this->belongsTo('Institute\Career');
	}
	public function groups()
	{
		return $this->hasMany('Institute\Group');
	}
}
