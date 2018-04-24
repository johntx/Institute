<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
	protected $table = 'assistances';
	protected $fillable = ['fecha', 'asistencia', 'inscription_id', 'people_id', 'group_id', 'subject_id'];

    public function inscription()
    {
        return $this->belongsTo('Institute\Inscription');
    }
    public function people()
    {
        return $this->belongsTo('Institute\People');
    }
    public function subject()
    {
        return $this->belongsTo('Institute\Subject');
    }
    public function group()
    {
        return $this->belongsTo('Institute\Group');
    }
}
