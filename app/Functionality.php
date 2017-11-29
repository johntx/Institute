<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Functionality extends Model
{
	protected $table = 'functionalities';

	protected $fillable = ['code', 'label', 'path', 'menu_id'];

	public $timestamps = false;
	public function setLabelAttribute($label)
	{
		$this->attributes['label']=ucwords(strtolower($label));
	}
	public function setCodeAttribute($code)
	{
		$this->attributes['code']=strtoupper($code);
	}
	public function menu()
	{
		return $this->belongsTo('Institute\Menu');
	}
	public function roles()
	{
		return $this->belongsToMany('Institute\Role','privileges');
	}
}
