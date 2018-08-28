<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
	protected $table = 'tests';
	protected $fillable = ['id','nombre','modulo','subject_id','career_id','orden'];

	public $timestamps = false;
	public function subject() {
		return $this->belongsTo('Institute\Subject');
	}
	public function career() {
		return $this->belongsTo('Institute\Career');
	}
    public function scores()
    {
        return $this->hasMany('Institute\Score');
    }
}
