<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
	protected $table = 'inscriptions';
	protected $fillable = ['estado', 'fecha_ingreso', 'fecha_retiro', 'monto', 'abono', 'total', 'colegiatura', 'people_id', 'group_id', 'particular_id', 'user_id'];

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
    public function payments()
    {
        return $this->hasMany('Institute\Payment');
    }
    public function assistances()
    {
        return $this->hasMany('Institute\Assistance');
    }
    public function asistencia($subject_id,$people_id,$fecha)
    {
        $assistances = \Institute\Assistance::where('fecha',$fecha)
        ->where('group_id',$this->group_id)
        ->where('asistencia',1)
        ->where('subject_id',$subject_id)
        ->where('people_id',$people_id)
        ->where('inscription_id',$this->id)
        ->get();
        if (count($assistances)>0) {
            return true;
        } else {
            return false;
        }
    }
    public function nota($partial_id,$people_id,$subject_id)
    {
        $score = \Institute\Score::where('partial_id',$partial_id)
        ->where('inscription_id',$this->id)
        ->where('group_id',$this->group_id)
        ->where('subject_id',$subject_id)
        ->where('people_id',$people_id)
        ->first();
        return $score->nota;
    }
    public function asisCont()
    {
        $assistances = \Institute\Assistance::where('asistencia',1)
        ->where('group_id',$this->group_id)
        ->where('inscription_id',$this->id)
        ->groupBy('fecha')
        ->get();
        $cant=0;
        $assistances->each(function($asistencia)
        {
            
        });
        return count($assistances);
    }
    public function myAsisCont($subject_id,$people_id)
    {
        $assistances = \Institute\Assistance::where('asistencia',1)
        ->where('group_id',$this->group_id)
        ->where('inscription_id',$this->id)
        ->where('subject_id',$subject_id)
        ->where('people_id',$people_id)
        ->groupBy('fecha')
        ->get();
        return count($assistances);
    }
    public function extras()
    {
        return $this->belongsToMany('Institute\Extra','inscriptions_extras');
    }
    public static function inscriptions($id){
        return Inscription::join('groups','inscriptions.group_id','=','groups.id')
        ->join('startclasses','groups.startclass_id','=','startclasses.id')
        ->join('careers','startclasses.career_id','=','careers.id')
        ->select('inscriptions.*','careers.nombre as carrera','startclasses.fecha_inicio','groups.turno')
        ->where('people_id',$id)
        ->groupBy('inscriptions.id')
        ->get();
    }
    public function debit(){
        $payment = $this->payments->where('estado','Pendiente')->first();
        if ($payment) {
            if (strtotime($payment->fecha_pagar) < strtotime(\Carbon\Carbon::now())) {
                return true;
            }
        }
        return null;
    }
    public function debitNext(){
        $payment = $this->payments->where('estado','Pendiente')->first();
        if ($payment) {
            if (strtotime($payment->fecha_pagar) < strtotime(\Carbon\Carbon::now()->addWeek(1)) && strtotime($payment->fecha_pagar) > strtotime(\Carbon\Carbon::now())) {
                return true;
            }
        }
        return null;
    }
    public function fechaInicioMes()
    {
        if (strtotime($this->group->startclass->fecha_inicio) > strtotime($this->people->fecha_ingreso)) {
            $fecha_inicio = $this->group->startclass->fecha_inicio;
        } else {
            $fecha_inicio = $this->people->fecha_ingreso;
        }
        $mes = $this->abono / $this->monto;
        $start_date = date('Y-m-d',strtotime('+'.intval($mes).' month', strtotime($fecha_inicio)));
        return $start_date;
    }
    public function fechaFinMes()
    {
        if (strtotime($this->group->startclass->fecha_inicio) > strtotime($this->people->fecha_ingreso)) {
            $fecha_inicio = $this->group->startclass->fecha_inicio;
        } else {
            $fecha_inicio = $this->people->fecha_ingreso;
        }
        $mes = $this->abono / $this->monto;
        $mes = intval($mes) + 1;
        $start_date_1 = date('Y-m-d',strtotime('-1 day', strtotime($fecha_inicio)));
        $start_date = date('Y-m-d',strtotime('+'.intval($mes).' month', strtotime($start_date_1)));
        return $start_date;
    }
}
