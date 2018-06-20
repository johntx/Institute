<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
	protected $table = 'classrooms';

	protected $fillable = ['area','piso','aula','office_id'];
	public $timestamps = false;

	public function office()
	{
		return $this->belongsTo('Institute\Office');
	}
}
