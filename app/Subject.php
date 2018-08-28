<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
	protected $table = 'subjects';
	protected $fillable = ['nombre'];

	public $timestamps = false;

	public function setNameAttribute($name)
	{
		$this->attributes['name']=strtoupper($name);
	}
	public function careers() {
		return $this->belongsToMany('Institute\Career','weekly');
	}
    public function tests()
    {
        return $this->hasMany('Institute\Test');
    }
    public function peoples()
    {
        return $this->belongsToMany('Institute\People','teaches');
    }
}
