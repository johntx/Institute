<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
	protected $table = 'families';
	protected $fillable = ['ci', 'nombre_completo', 'telefono', 'parentezco', 'student_id'];

	public $timestamps = false;

	public function student() {
		return $this->belongsTo('Institute\Student');
	}
}
