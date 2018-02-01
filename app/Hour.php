<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Hour extends Model
{
	protected $table = 'hours';

	protected $fillable = ['aula','piso','hora_inicio','hora_fin','periodos','dia','group_id','career_id','subject_id','schedule_id','people_id'];

	public $timestamps = false;
    public function people()
    {
        return $this->belongsTo('Institute\People');
    }
    public function career()
    {
        return $this->belongsTo('Institute\Career');
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
