<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
	protected $table = 'assistances';
	protected $fillable = ['fecha', 'inscription_id', 'teacher_id', 'subject_id'];

    public function inscription()
    {
        return $this->belongsTo('Institute\Inscription');
    }
    public function teacher()
    {
        return $this->belongsTo('Institute\Teacher');
    }
    public function subject()
    {
        return $this->belongsTo('Institute\Subject');
    }
}
