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
