<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
	use SoftDeletes;
	protected $table = 'roles';

	protected $fillable = ['code', 'name'];

	public $timestamps = false;
	protected $dates = ['deleted_at'];
	public function setNameAttribute($name)
	{
		$this->attributes['name']=strtoupper($name);
	}
	public function setCodeAttribute($code)
	{
		$this->attributes['code']=strtoupper($code);
	}
	public function functionalities()
	{
		return $this->belongsToMany('Institute\Functionality','privileges');
	}
	public function users()
	{
		return $this->hasMany('Institute\User');
	}
}
