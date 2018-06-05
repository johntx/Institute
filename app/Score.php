<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
	protected $table = 'scores';
	protected $fillable = ['inscription_id', 'people_id', 'group_id', 'subject_id', 'partial_id','nota','detalle', 'fecha'];

    public function inscription()
    {
        return $this->belongsTo('Institute\Inscription');
    }
	public function people() {
		return $this->belongsTo('Institute\People');
	}
	public function user() {
		return $this->belongsTo('Institute\User');
	}
	public function group() {
		return $this->belongsTo('Institute\Group');
	}
	public function subject() {
		return $this->belongsTo('Institute\Subject');
	}
	public function partial() {
		return $this->belongsTo('Institute\Partial');
	}
}
