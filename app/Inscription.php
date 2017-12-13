<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
	protected $table = 'inscriptions';
	protected $fillable = ['estado', 'fecha_retiro', 'monto', 'abono', 'total', 'colegiatura', 'people_id', 'career_id', 'group_id', 'particular_id', 'user_id'];

    public function people()
    {
        return $this->belongsTo('Institute\People');
    }
    public function career()
    {
        return $this->belongsTo('Institute\Career');
    }
    public function group()
    {
        return $this->belongsTo('Institute\Group');
    }
    public function user()
    {
        return $this->belongsTo('Institute\User');
    }
    public static function inscriptions($id){
        return Inscription::
        join('careers','inscriptions.career_id','=','careers.id')
        ->join('groups','inscriptions.group_id','=','groups.id')
        ->join('startclasses','groups.startclass_id','=','startclasses.id')
        ->select('inscriptions.*','careers.nombre as carrera','startclasses.fecha_inicio','groups.turno')
        ->where('people_id',$id)
        ->groupBy('inscriptions.id')
        ->get();
    }
}
