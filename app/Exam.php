<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
	protected $table = 'exams';
	protected $fillable = ['pregunta','respuesta1','respuesta2','respuesta3','respuesta4','respuesta5','correcta'];

	public $timestamps = false;
	
	public function setPreguntaAttribute($pregunta)
	{
		$this->attributes['pregunta']=strtoupper($pregunta);
	}
}
