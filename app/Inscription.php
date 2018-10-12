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
    public function scores()
    {
        return $this->hasMany('Institute\Score');
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
    public function asistencia_personalizada($subject_id,$people_id,$fecha,$n)
    {
        $assistances = \Institute\Assistance::where('fecha',$fecha)
        ->where('group_id',$this->group_id)
        ->where('asistencia',$n)
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
    public function nota($test)
    {
        $score = $test->scores->where('inscription_id',$this->id)->first();
        if (count($score)==0) {
            return null;
        }
        return $score;
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
        ->where('inscriptions.estado','Inscrito')
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
    public function asistencias_semana()
    {
        $hoy = \Carbon\Carbon::now()->format('Y-m-d');
        $semanas = \Carbon\Carbon::now()->subWeek()->subWeek()->format('Y-m-d');
        $assistances = \Institute\Assistance::where('asistencia',1)
        ->where('inscription_id',$this->id)
        ->whereBetween('fecha', array($semanas, $hoy))
        ->get();
        return count($assistances);
    }
    public function alumno_antiguo()
    {
        $semanas = \Carbon\Carbon::now()->subWeek()->subWeek();
        $fecha_ingreso = \Carbon\Carbon::parse($this->fecha_ingreso);
        $fecha_start_class = \Carbon\Carbon::parse($this->group->startclass->fecha_inicio);
        if($fecha_ingreso > $fecha_start_class){
            $fecha_inicio = $fecha_ingreso;
        }else{
            $fecha_inicio = $fecha_start_class;
        }
        if ($fecha_inicio < $semanas) {return true;} else {return false;}
    }
}
