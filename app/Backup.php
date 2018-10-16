<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    protected $table = 'backups';
    protected $fillable = ['nombre','direccion','created_at'];
}
