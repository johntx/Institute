<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
	protected $table = 'inscriptions';
	protected $fillable = ['estado', 'inscrito', 'student_id', 'career_id', 'group_id', 'user_id'];

	public $timestamps = false;

    public function student()
    {
        return $this->belongsTo('Institute\Student');
    }
    public function career()
    {
        return $this->belongsTo('Institute\Career');
    }
    public function group()
    {
        return $this->belongsTo('Institute\Group');
    }
    public function user()
    {
        return $this->belongsTo('Institute\User');
    }
}
