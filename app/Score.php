<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
	protected $table = 'scores';
	protected $fillable = ['nota','inscription_id','test_id','people_id','group_id'];

    public function inscription()
    {
        return $this->belongsTo('Institute\Inscription');
    }
	public function test() {
		return $this->belongsTo('Institute\Test');
	}
	public function people() {
		return $this->belongsTo('Institute\People');
	}
	public function group() {
		return $this->belongsTo('Institute\Group');
	}
}
