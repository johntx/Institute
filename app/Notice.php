<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
	protected $table = 'notices';
	protected $fillable = ['fecha', 'tipo', 'titulo', 'texto', 'foto', 'user_id'];

	public $timestamps = false;

	public function user() {
		return $this->belongsTo('Institute\User');
	}
}
