<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	protected $table = 'groups';
	protected $fillable = ['nombre', 'turno', 'estado', 'startclass_id'];

	public $timestamps = false;

	public function career() {
		return $this->belongsTo('Institute\Career');
	}
    public function startclass()
    {
        return $this->belongsTo('Institute\Startclass');
    }
}
