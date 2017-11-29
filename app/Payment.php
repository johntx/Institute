<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	protected $table = 'payments';
	protected $fillable = ['fecha_pagar', 'estado', 'abono', 'saldo', 'inscription_id', 'user_id'];

	public function user() {
		return $this->belongsTo('Institute\User','id');
	}
    public function inscription()
    {
        return $this->belongsTo('Institute\Inscription');
    }
}
