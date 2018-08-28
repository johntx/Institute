<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
	protected $table = 'bots';

	protected $fillable = ['id','nombre','fecha'];
}
