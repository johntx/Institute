<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	protected $table = 'menus';

	protected $fillable = ['code','label', 'icon','orden'];

	public $timestamps = false;
	public function setCodeAttribute($code)
	{
		$this->attributes['code']=strtoupper($code);
	}
	public function setLabelAttribute($label)
	{
		$this->attributes['label']=ucwords(strtolower($label));
	}
	public function functionalities()
	{
		return $this->hasMany('Institute\Functionality');
	}
}
