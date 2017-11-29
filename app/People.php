<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
	protected $table = 'peoples';
	protected $fillable = ['id', 'code', 'ci', 'nombre', 'paterno', 'materno', 'fecha_ingreso', 'fecha_nacimiento', 'nacionalidad', 'estado_civil', 'direccion', 'telefono', 'genero', 'tipo_sanguineo', 'email', 'office_id'];

	public $timestamps = false;

	public function user() {
		return $this->belongsTo('Institute\User','id');
	}
    public function inscription()
    {
        return $this->belongsTo('Institute\Inscription');
    }
    public function office()
    {
        return $this->belongsTo('Institute\Office');
    }
    public function nombrecompleto(){
    	return $this->nombre.' '.$this->paterno.' '.$this->materno;
    }
}
