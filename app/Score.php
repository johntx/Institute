<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
	protected $table = 'scores';
	protected $fillable = ['inscription_id', 'teacher_id', 'group_id', 'subject_id', 'partial_id', 'nota'];

    public function inscription()
    {
        return $this->belongsTo('Institute\Inscription');
    }
	public function teacher() {
		return $this->belongsTo('Institute\Teacher');
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
