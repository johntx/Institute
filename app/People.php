<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
	protected $table = 'peoples';
	protected $fillable = ['id', 'code', 'ci', 'nombre','pago_hora', 'paterno', 'observacion', 'fecha_nacimiento', 'nacionalidad', 'estado_civil', 'direccion', 'telefono', 'encuesta', 'carrera', 'telefono2', 'office_id'];

	public $timestamps = false;

	public function user() {
		return $this->belongsTo('Institute\User','id');
	}
    public function inscriptions()
    {
        return $this->hasMany('Institute\Inscription');
    }
    public function office()
    {
        return $this->belongsTo('Institute\Office');
    }
    public function nombrecompleto(){
        return $this->nombre.' '.$this->paterno;
    }
    public function iniciales(){
    	return substr($this->nombre, 0, 1).' '.substr($this->paterno, 0, 1);
    }
    public function subjects() {
        return $this->belongsToMany('Institute\Subject','teaches');
    }
    public function hours()
    {
        return $this->hasMany('Institute\Hour');
    }
}
