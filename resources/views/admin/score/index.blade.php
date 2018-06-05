@extends('layouts.admin')
@section('content')
{!! Form::open(['route' => ['admin.score.store']]) !!}
<div class="table-responsive vista_movil">
	<table class="table table-hover table-condensed">
		<thead>
			<th>No</th>
			<th class="centro">Add Nota<br>
			<input type="text" name="fecha" placeholder="Fecha.." style="width: 80px;" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" class="datepicker">
			<input type="text" name="partial" placeholder="Detalle.." style="width: 80px;">
			</th>
			<th>Nombre</th>
			@foreach ($scores as $k=>$score)
			<th class="contenedor_fechas">
				<div class="partial_name">{{$score->partial->nombre}}</div>
				<div class="fecha_vertical">{{\Carbon\Carbon::parse($score->fecha)->format('d/m/y')}}
				</div>
				<p class="dia_inicial">{{strtoupper(\Jenssegers\Date\Date::parse($score->fecha)->format('l')[0])}}{{\Jenssegers\Date\Date::parse($score->fecha)->format('l')[1]}}</p>
			</th>
			<?php $cont[$k]=0; ?>
			@endforeach
		</thead>
		@foreach($inscriptions as $i=>$inscription)
		<tr @if ($inscription->estado == 'Retirado') style="background-color: rgba(255,0,0,0.25);" @endif>
			<td>{{++$i}}</td>
			<td class="centro">
				<input type="text" name="nota[]" value="" style="width:40px;">
				<input type="hidden" name="inscription_id[]" value="{{$inscription->id}}">
			</td>
			<td>{{$inscription->people->nombrecompleto()}}</td>
			@foreach ($scores as $k=>$score)
			<td class="right">{{$inscription->nota($score->partial_id,$score->people_id,$score->subject_id)}}</td>
			@endforeach
		</tr>
		@endforeach
		<tr>
			<td></td>
			<td class="centro">
				<input type="hidden" name="subject_id" value="{{$subject_id}}"><input type="hidden" name="group_id" value="{{$group_id}}"><input class="btn btn-primary" type="submit" value="Registrar">
			</td>
			<td></td>
			<td></td>
		</tr>
	</table>
</div>
{!! Form::close() !!}
<style>
	.vista_movil *{font-size: 12px;}
	.vista_movil td{padding: 4px !important;}
	.vista_movil td form{margin: 0 !important;}
	.switch{margin: 0;}
	.centro{text-align: center;}
	.contenedor_fechas{position:relative;height:130px;width:50px;}
	.partial_name{transform:rotate(90deg);position:absolute;top:45px;right:-41px;width: 100px;height:15px;}
	.fecha_vertical{font-size:10px;transform:rotate(90deg);position:absolute;top:20px;right:-1px;margin:0;width: 50px;height:15px;}
	.dia_inicial{margin: 0;font-size: 12px;left: 0px;text-align: right;}
	.right{text-align:right;}
</style>
@endsection