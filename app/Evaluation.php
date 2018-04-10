<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
	protected $table = 'evaluations';

	protected $fillable = ['fecha','people_id','p1','p2','p3','p4','p5','p6','inscription_id'];

	public $timestamps = false;
    public function people()
    {
        return $this->belongsTo('Institute\People');
    }
    public function inscription()
    {
        return $this->belongsTo('Institute\Inscription');
    }
}
