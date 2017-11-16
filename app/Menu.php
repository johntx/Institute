<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
	use SoftDeletes;
	protected $table = 'menus';

	protected $fillable = ['code','label', 'icon'];

	public $timestamps = false;
	protected $dates = ['deleted_at'];
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
