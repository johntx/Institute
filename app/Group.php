<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	protected $table = 'groups';
	protected $fillable = ['nombre', 'limite', 'turno', 'career_id', 'startclasses_id'];

	public $timestamps = false;

	public function career() {
		return $this->belongsTo('Institute\Career');
	}
    public function startclasses()
    {
        return $this->belongsTo('Institute\Startclasses');
    }
}
