@extends('layouts.admin')
@section('content')
@include('alerts.request')
<h4>Docente: <b>{{$people->nombrecompleto()}}</b> - (Pago por Hora: <b id="pxh">{{$people->genero}}</b> Bs.)</h4>
<div class="table-responsive">

	<table style="border: 1px solid black;" class="table table-hover">
		<tr>
			<th style="text-align:center;">Fecha</th>
			<th>tipo</th>
			<th style="text-align:center;">Hora Tickeo</th>
			<th style="text-align:center;">Hora Ajuste</th>
			<th style="text-align:center;">Invalidar</th>
			<th style="text-align:center;">Crear</th>
			<th>Horas Sumadas</th>
			<th>Cancelar</th>
		</tr>
		<?php $pos=1; $cam=false;
		$fecha1=\Carbon\Carbon::parse($fechas[0])->format('Y-m-d'); $fecha2=null; $b=true; ?>
		@foreach($fechas as $k=>$fecha)
		<tbody style="border-top: 1px solid black;">
			<?php $tickeos =  \Institute\Tickeo::select('tickeos.*')->where('biometric_id',$people->code)->whereBetween('fecha',array(Carbon\Carbon::parse($fecha)->format('Y-m-d 00:00:00'),Carbon\Carbon::parse($fecha)->format('Y-m-d 23:59:59')))->where('estado','!=','invalido')->orderBy('fecha','asc')->get();
			?>
			<?php $fecha2=\Carbon\Carbon::parse($fecha)->format('Y-m-d');
			if (count($tickeos)>0 && $fecha2!=$fecha1 && $b) {
				$b=false;
			} elseif (count($tickeos)>0 && $fecha2!=$fecha1 && !$b) {
				$b=true;
			}
			if (count($tickeos)>0 && $k+1 < count($fechas)) {
				$fecha2 = \Carbon\Carbon::parse($fechas[$k+1])->format('Y-m-d');
			}
			$fecha1 = \Carbon\Carbon::parse($fechas[$k])->format('Y-m-d');
			?>
			@foreach ($tickeos as $k=>$tickeo)
			<tr @if ($b) style="background-color: #E2E2E2;"@endif @if ($tickeo->estado == 'creado') style="background-color: #93D299;"@endif>
				<?php
				$hora = \Carbon\Carbon::parse($tickeo->fecha)->format('H:i:s');
				$min = \Carbon\Carbon::parse($tickeo->fecha)->format('i');
				if($tickeo->tipo == 0){
					if($min>=0 && $min<=15){
						$ajuste = \Carbon\Carbon::parse($tickeo->fecha)->format('H:00:00');
					} elseif($min>=46 && $min<=59) {
						$ajuste = \Carbon\Carbon::parse($tickeo->fecha)->addHours(1)->format('H:00:00');
					} else {
						$ajuste = \Carbon\Carbon::parse($tickeo->fecha)->format('H:i:s');
					}
				} else {
					if($min>=0 && $min<=20){
						$ajuste = \Carbon\Carbon::parse($tickeo->fecha)->format('H:00:00');
					} elseif($min<=50) {
						$ajuste = \Carbon\Carbon::parse($tickeo->fecha)->format('H:30:00');
					} else {
						$ajuste = \Carbon\Carbon::parse($tickeo->fecha)->format('H:i:s');
					}
				}
				?>
				@if ($k==0)
				<td style="text-align: center;"><b>{{Jenssegers\Date\Date::parse($fecha)->format('d/m/y')}}</b></td>
				@elseif ($k==1)
				<td rowspan="{{count($tickeos)-1}}"><p style="text-align: center;">({{\Jenssegers\Date\Date::parse($fecha)->format('l')}}) </p></td>
				@endif
				<td>@if ($tickeo->tipo == 0)Entrada @if ($tickeo->estado == "observado") (observado)@endif @else Salida @if ($tickeo->estado == "observado") (observado)@endif <?php $cam=true;?>@endif</td>
				<td style="text-align:center;">{{$hora}}</td>
				<td style="text-align:center;"@if ($tickeo->tipo == 0) e_pos='{{$pos}}'@else s_pos='{{$pos}}'@endif>{{$ajuste}}</td>
				<td style="text-align:center;"><button type="button" class="btn btn-xs btn-warning btn_invalidar" data-toggle="modal" data-target=".bs-delete-modal-sm{{$tickeo->id}}">×</button></td>
				<td style="text-align:center;"><button type="button" class="btn btn-xs btn-success btn_invalidar" data-toggle="modal" data-target=".bs-create-modal-sm{{$tickeo->id}}">+</button></td>
				@if ($k % 2 == 0)<td rowspan="2">
				<span class="span_res" r_pos='{{$pos}}' hora_fecha='{{$fecha}}'></span> Hs. 
				<button class="btn btn-primary" ed_pos='{{$pos}}' class="edit_hora" onclick="editar_hora(this)" type="button" style="padding: 2px 0.2px 2px 2px;" data-target=".modal_editar" data-toggle="modal">
					<i class="fa fa-edit fa-fw"></i>
				</button>
			</td>@endif
			@if ($k==0)
			<td rowspan="{{count($tickeos)}}"
			<?php $tickeos_cont = \Institute\Tickeo::select('tickeos.*')->where('biometric_id',$people->code)->whereBetween('fecha',array(Carbon\Carbon::parse($fecha)->format('Y-m-d 00:00:00'),Carbon\Carbon::parse($fecha)->format('Y-m-d 23:59:59')))->where('estado','!=','invalido')->where('cancelado','!=','si')->get(); ?>
			@if (count($tickeos_cont)>0)
			><input type="checkbox" class="check" name="cancelado" value="{{$fecha}}" style="width: 100%; height: 35px;">
			@else
			style="background-color:#F15D5D;text-align:center;vertical-align:middle;color:white;">CANCELADO
			@endif
		</td>
		@endif

		<div class="modal fade bs-create-modal-sm{{$tickeo->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-sm" role="document" style="z-index:2000;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Invalidar Tickeo</h4>
					</div>
					{!! Form::open(['route' => ['admin.tickeo.store',$tickeo->id],'method'=>'post']) !!}
					<div class="modal-body">
						<p>Crear tickeo:</p>
						<p>{{$tickeo->biometric->nombre}}</p>
						<input class="form-control" type="text" name="fecha" value="{{$tickeo->fecha}}">
						<br>
						<select class="form-control" name="tipo">
							<option value="0">Entrada</option>
							<option value="1">Salida</option>
						</select>
						<input type="hidden" name="estado" value="creado">
						<input type="hidden" name="biometric_id" value="{{$tickeo->biometric_id}}">
					</div>
					<div class="modal-footer">
						<input type="hidden" name="url" value="{{$_SERVER['REQUEST_URI']}}" >
						{!! Form::submit('Crear',['class'=>' btn-success','style' => 'float:left;padding: 6px 12px;']) !!}
						{!! Form::close() !!}
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade bs-delete-modal-sm{{$tickeo->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-sm" role="document" style="z-index:2000;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Invalidar Tickeo</h4>
					</div>
					<div class="modal-body">
						<p>Esta seguro que desea invalidar el tickeo:</p>
						<p>{{$tickeo->biometric->nombre}}</p>
						<p>{{$tickeo->fecha}}</p>
					</div>
					<div class="modal-footer">
						{!! Form::open(['route' => ['admin.tickeo.update',$tickeo->id],'method'=>'put']) !!}
						<input type="hidden" name="url" value="{{$_SERVER['REQUEST_URI']}}" >
						{!! Form::submit('Invalidar',['class'=>' btn-danger','style' => 'float:left;padding: 6px 12px;']) !!}
						{!! Form::close() !!}
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
		<?php
		if($cam){
			$pos++;
			$cam=false;
		}
		?>
	</tr>
	@endforeach
</tbody>
@endforeach
</table>
</div>
<div id="modal_pagar_overall" class="panel panel-default" style="display: none; width: 350px; position: fixed; top: 20%; left: 40%;-webkit-box-shadow: 10px 10px 13px 1px rgba(0,0,0,0.45);
-moz-box-shadow: 10px 10px 13px 1px rgba(0,0,0,0.45);
box-shadow: 10px 10px 13px 1px rgba(0,0,0,0.45);">
	<div class="panel-heading">Pagar Horas</div>
	<div class="panel-body">
		<p>Esta seguro que desea registrar el pago</p>
		<p>{{$tickeo->biometric->nombre}}</p>
		<p id="horas_pagar"></p>
		<p id="monto_pagar"></p>
	</div>
	<div class="panel-footer">
		{!! Form::open(['url'=>'teacher/payment_ajax','id'=>"form_pagar"]) !!}
		<input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
		<input type="hidden" id="i_horas_pagar" name="horas" value="">
		<input type="hidden" id="i_monto_pagar" name="monto" value="">
		<input type="hidden" name="code" value="{{$people->code}}">
		<input type="hidden" name="people_id" value="{{$people->id}}">
		<input type="hidden" name="url" value="{{$_SERVER['REQUEST_URI']}}">
		{!! Form::submit('Pagar',['class'=>'btn btn-success']) !!}
		{!! Form::close() !!}
		<button type="button" class="btn btn-default" onclick="ocultar()">Cancelar</button>
	</div>
</div>
<div class="modal fade modal_editar" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm" role="document" style="z-index:2000;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Editar Hora</h4>
			</div>
			<div class="modal-body">
				<input type="text" id="input_hora" t_pos="" value="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" id="edit_ok" data-dismiss="modal">Editar</button>
				<button type="button" onclick="clean();" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>
<style>
	td{ padding: 2px !important; }
</style>
@endsection
@section('admincss')
{!! Html::style('css/pdf_tickeo.css') !!}
@endsection
@section('adminjs')
{!! Html::script('js/tickeo.js') !!}
@endsection