<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	protected $table = 'payments';
	protected $fillable = ['fecha_pagar', 'fecha_pago', 'observacion', 'estado', 'abono', 'descuento', 'saldo', 'inscription_id', 'user_id','created_at'];

	public function user() {
		return $this->belongsTo('Institute\User','id');
	}
	public function inscription()
	{
		return $this->belongsTo('Institute\Inscription');
	}
	public static function payments($id){
		return Payment::
		where('inscription_id',$id)
		->orderBy('id','DESC')
		->get();
	}
}
