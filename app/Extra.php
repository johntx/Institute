<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
	protected $table = 'extras';
	protected $fillable = ['nombre', 'precio'];

	public $timestamps = false;
	
	public function setNombreAttribute($nombre)
	{
		$this->attributes['nombre']=strtoupper($nombre);
	}
    public function inscriptions()
    {
        return $this->belongsToMany('Institute\Inscriptions','inscriptions_extras');
    }
}
