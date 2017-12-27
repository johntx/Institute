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
    public function payments()
    {
        return $this->hasMany('Institute\Payment');
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
    public function lastSaldoPayment(){
        $payment = $this->payments->where('estado','Pendiente')->first();
        if ($payment) {
            return $payment->saldo;
        }
        return "<b>Sin deudas</b>";
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
}
