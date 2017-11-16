<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Functionality extends Model
{
	use SoftDeletes;
	protected $table = 'functionalities';

	protected $fillable = ['code', 'label', 'path', 'menu_id'];

	public $timestamps = false;
	protected $dates = ['deleted_at'];
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
