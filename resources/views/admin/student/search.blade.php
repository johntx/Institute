@extends('layouts.admin')
@section('content')
@include('alerts.request')
<br>
<div class="panel panel-info">
	<div class="panel-heading">DATOS DEL ESTUDIANTE</div>
	<div class="panel-body">
		<p class="col-sm-6"><b>Usuario:</b> {{$student->user->user }}</p>
		<p class="col-sm-6"><b>CI:</b> {{$student->ci }}</p>
		<p class="col-sm-6"><b>Nombre:</b> {{$student->nombrecompleto() }}</p>
		<p class="col-sm-6"><b>Fecha de Nacimiento:</b> {{ Jenssegers\Date\Date::parse($student->fecha_nacimiento)->format('j M Y') }}</p>
		<p class="col-sm-6"><b>Telefono:</b> {{$student->telefono }}</p>
	</div>
</div>
@foreach ($student->inscriptions as $inscription)
<div class="panel panel-success">
	<div class="panel-heading">DATOS DE INSCRIPCIÓN - CARRERA ({{$inscription->career->nombre}})</div>
	<div class="panel-body">
		<p class="col-sm-6"><b>Id:</b> {{$inscription->id }}</p>
		<p class="col-sm-6">&nbsp;</p>
		<p class="col-sm-6"><b>Estado:</b> {{$inscription->estado }}</p>
		<p class="col-sm-6"><b>Pago por mes:</b> {{$inscription->monto }}</p>
		<p class="col-sm-6"><b>Carrera:</b> {{$inscription->career->nombre }}</p>
		<p class="col-sm-6"><b>Total pagado:</b> {{$inscription->abono }}</p>
		<p class="col-sm-6"><b>Grupo:</b> {{$inscription->group->turno }}</p>
		<p class="col-sm-6"><b>Total a pagar:</b> {{$inscription->total }}</p>
		<p class="col-sm-6"><b>Fecha Ingreso:</b> {{Jenssegers\Date\Date::parse($inscription->fecha_ingreso)->format('j M Y')}}</p>
		<p class="col-sm-6">
			@if ($inscription->fecha_retiro != null)
			<b>Fecha Retiro:</b> {{Jenssegers\Date\Date::parse($inscription->fecha_retiro)->format('j M Y') }}
			@endif
			&nbsp;
		</p>
		<p class="col-sm-6"><b>Fecha inicio de clases:</b> {{Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_inicio)->format('j M Y')}}</p>
		<p class="col-sm-6"><b>Fecha fin de clases:</b> {{Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_fin)->format('j M Y')}}</p>
	</div>
	<div class="table-responsive">
		<table class="table table-hover">
			<thead style="background-color: #EEEEEE;">
				<th>Id</th>
				<th>Fecha Pagar</th>
				<th>Pagó</th>
				<th>Abono</th>
				<th>Saldo</th>
				<th>Estado</th>
				<th>Observaciones</th>
			</thead>
			@foreach ($inscription->payments()->orderBy('id','DESC')->get() as $payment)
			<tbody>
				<td>{{$payment->id}}</td>
				<td>{{Jenssegers\Date\Date::parse($payment->fecha_pagar)->format('j M Y')}}</td>
				<td>
					@if ($payment->fecha_pago != null)
					{{Jenssegers\Date\Date::parse($payment->fecha_pago)->format('j M Y')}}
					@endif
				</td>
				<td>
					@if ($payment->abono != 0)
					{{$payment->abono}}
					@endif
				</td>
				<td>{{$payment->saldo}}</td>
				<td>{{$payment->estado}}</td>
				<td>{{$payment->observacion}}</td>
			</tbody>
			@endforeach
		</table>
	</div>
</div>
@endforeach

@endsection