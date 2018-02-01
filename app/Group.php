<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;
use DB;

class Group extends Model
{
	protected $table = 'groups';
	protected $fillable = ['nombre', 'turno', 'estado', 'startclass_id'];

	public $timestamps = false;

    public function startclass()
    {
        return $this->belongsTo('Institute\Startclass');
    }
	public static function groups($id){
		return Group::leftjoin('inscriptions','groups.id','=','inscriptions.group_id')
		->join('startclasses','groups.startclass_id','=','startclasses.id')
		->join('careers','startclasses.career_id','=','careers.id')
		->select('groups.*','careers.nombre', DB::raw('count(inscriptions.id) as inscritos'))
		->groupBy('groups.id')
		->where('startclass_id',$id)
		->get();
	}
	public function inscriptions()
	{
		return $this->hasMany('Institute\Inscription');
	}
    public function hours()
    {
        return $this->hasMany('Institute\Hour');
    }
}
