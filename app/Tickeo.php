<?php

namespace Institute;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Jenssegers\Date\Date;

class Tickeo extends Model
{
	protected $table = 'tickeos';

	protected $fillable = ['tipo','fecha','estado','biometric_id','dia'];

	public $timestamps = false;
	
	public function biometric()
	{
		return $this->belongsTo('Institute\Biometric');
	}
	public function AutoAjustar($biometric_id,$fecha)
	{
        $tickeos = Tickeo::where('biometric_id',$biometric_id)->where('tipo','0')->whereBetween('fecha',array(Carbon::parse($fecha)->format('Y-m-d 00:00:00'),Carbon::parse($fecha)->format('Y-m-d 23:59:59')))->orderBy('fecha','asc')->get();
        if (count($tickeos)==0) {
            return null;
        }
		$col = collect();
		$tickeos->first()->dia = Date::parse($tickeos->first()->fecha)->format('l');
		$col->push($tickeos->first());
		foreach ($tickeos as $key => $tickeo) {
			$fecha_tickeo = Date::parse($tickeo->fecha);
			$fecha_col = Date::parse($col->last()->fecha);
			if ($fecha_tickeo->diffInMinutes($fecha_col) <= 30 && $tickeo->tipo == $col->last()->tipo) {
			} else {
				$tickeo->dia = $fecha_tickeo->format('l');
				$col->push($tickeo);
			}
		}
        $tickeos = Tickeo::where('biometric_id',$biometric_id)->where('tipo','1')->whereBetween('fecha',array(Carbon::parse($fecha)->format('Y-m-d 00:00:00'),Carbon::parse($fecha)->format('Y-m-d 23:59:59')))->orderBy('fecha','asc')->get();
        if (count($tickeos)==0) {
            return null;
        }
		$col2 = collect();
		$tickeos->first()->dia = Date::parse($tickeos->first()->fecha)->format('l');
		$col2->push($tickeos->first());
		foreach ($tickeos as $key => $tickeo) {
			$fecha_tickeo = Date::parse($tickeo->fecha);
			$fecha_col = Date::parse($col2->last()->fecha);
			if ($fecha_tickeo->diffInMinutes($fecha_col) <= 30 && $tickeo->tipo == $col2->last()->tipo) {
			} else {
				$tickeo->dia = $fecha_tickeo->format('l');
				$col2->push($tickeo);
			}
		}
		$col = $col->merge($col2);
		$col = $col->sortBy('fecha');
		return $col;
	}
}
