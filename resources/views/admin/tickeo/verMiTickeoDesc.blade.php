@extends('layouts.admin')
@section('content')
<h4>Docente: <b>{{$people->nombrecompleto()}}</b> Biometrico: <b>({{$tickeos->first()->biometric->nombre}})</b></h4>
<div class="table-responsive">
	<table style="border: 1px solid black;">
		<tr>
			<th>Fecha</th>
			<th>tipo</th>
			<th>Hora</th>
			<th>Registro</th>
			<th>Retraso</th>
			<th>Horas trabajadas</th>
			<th>Dia</th>
		</tr>
		@foreach($fechas as $fecha)
		@foreach ($hours as $hora)
		@if (Date::parse($fecha)->format('l') == $hora['dia'])
		<tbody style="border-top: 1px solid black;">
			<tr>
				<td>{{Jenssegers\Date\Date::parse($fecha)->format('d/m/y')}}</td>
				<td>Entrada:</td>
				<?php $fecha_inicio = \Carbon\Carbon::parse($fecha)->format('Y-m-d '.$hora->hora_inicio.':00'); ?>
				<td>{{\Carbon\Carbon::parse($fecha_inicio)->format('H:i')}}</td>
				<?php $tickeo1 = \Institute\Tickeo::where('biometric_id',$people->code)->whereBetween('fecha', array(date ('Y-m-d H:i:s',strtotime('-2 hour',strtotime($fecha_inicio))), date ('Y-m-d H:i:s',strtotime('+2 hour',strtotime($fecha_inicio))) ))->where('tipo',0)->orderBy('fecha','asc')->get(); ?>
				<td>@if (count($tickeo1)>0) {{\Carbon\Carbon::parse($tickeo1->first()['fecha'])->format('H:i')}} @endif</td>
				<?php $ni=0; if(count($tickeo1)>0){$Fecha1=\Carbon\Carbon::parse($fecha_inicio);$Fecha2=\Carbon\Carbon::parse($tickeo1->first()['fecha']);if($Fecha1->format('H:i')>$Fecha2->format('H:i')){$intervalo='0 minutos'; $ni = 0;} else {$intervalo = $Fecha1->diff($Fecha2);$ni = $intervalo->format('%i');	$intervalo = $intervalo->format('%i minutos'); }}else{ $intervalo=''; } ?>
				<td @if ($ni>15) style="background-color: red; color: white;" @endif>{{$intervalo}}</td>
				<td></td>
				<td>{{$hora['dia']}}</td>
			</tr>
			<tr>
				<td></td>
				<td>Salida:</td>
				<?php $fecha_fin = \Carbon\Carbon::parse($fecha)->format('Y-m-d '.$hora->hora_fin.':00'); ?>
				<td>{{\Carbon\Carbon::parse($fecha_fin)->format('H:i')}}</td>
				<?php $tickeo2 = \Institute\Tickeo::where('biometric_id',$people->code)->whereBetween('fecha', array(date ('Y-m-d H:i:s',strtotime('-2 hour',strtotime($fecha_fin))), date ('Y-m-d H:i:s',strtotime('+2 hour',strtotime($fecha_fin))) ))->where('tipo',1)->orderBy('fecha','asc')->get(); ?>
				<td>@if (count($tickeo2)>0) {{\Carbon\Carbon::parse($tickeo2->last()['fecha'])->format('H:i')}} @endif</td>
				<?php $ni2=0; if(count($tickeo2)>0){$Fecha1=\Carbon\Carbon::parse($fecha_fin);$Fecha2=\Carbon\Carbon::parse($tickeo2->first()['fecha']);if($Fecha1->format('H:i')<$Fecha2->format('H:i')){$intervalo2='0 minutos'; $ni2 = 0;} else {	$intervalo2 = $Fecha2->diff($Fecha1);	$ni2 = $intervalo2->format('%i');	$intervalo2 = $intervalo2->format('%i minutos'); }}else{ $intervalo2=''; } ?>
				<td @if ($ni2>0) style="background-color: red; color: white;"@endif>{{$intervalo2}}</td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
		@endif
		@endforeach
		@endforeach
	</table>
</div>
@endsection
@section('admincss')
{!! Html::style('css/pdf_tickeo.css') !!}
@endsection