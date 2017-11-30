<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
	protected $table = 'inscriptions';
	protected $fillable = ['estado', 'people_id', 'career_id', 'group_id', 'particular_id', 'user_id'];

	public $timestamps = false;

    public function student()
    {
        return $this->belongsTo('Institute\People');
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
