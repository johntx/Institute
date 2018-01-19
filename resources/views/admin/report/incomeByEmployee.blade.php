@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="panel panel-info">
	<div class="panel-body">
	<div class=" col-xs-5" style="padding: 0;">
		{!! Form::label('Fecha Inicio') !!}
		{!! Form::text('fecha_inicio',\Carbon\Carbon::now()->format('Y-m-d'),['class'=>'form-control datepicker date_ingresos','placeholder'=>'yyyy-mm-dd','id'=>'date_ingresos_inicio']) !!}
	</div>
	<div class="col-xs-5">
		{!! Form::label('Fecha Fin') !!}
		{!! Form::text('fecha_fin',\Carbon\Carbon::now()->format('Y-m-d'),['class'=>'form-control datepicker date_ingresos','placeholder'=>'yyyy-mm-dd','id'=>'date_ingresos_fin']) !!}
	</div>
	<div class="col-xs-2">
		{!!link_to_action('admin/report/incomeByEmployee', $title = 'Cambiar Fechas', $parameters = $payment->id, $attributes = ['class'=>'btn btn-info','fecha_inicio'=>$fecha_inicio])!!}
	</div>
</div>
</div>
@foreach($users as $user)
<div class="panel panel-primary">
	<div class="panel-heading">{{$user->people->nombrecompleto()}}</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-hover table-condensed">
				<thead>
					<th>Id</th>
					<th>Cliente</th>
					<th>Pagó</th>
					<th>Carrera</th>
					<th>Abono</th>
					<th>Saldo</th>
					<th>Total</th>
					<th>Usuario</th>
				</thead>
				@foreach($user->payments()->where('estado','Pagado')->whereBetween('fecha_pago',array($fecha_inicio, $fecha_fin))->get() as $payment)
				<tbody>
					<td>{{$payment->id}}</td>
					<td>{{$payment->inscription->people->nombrecompleto()}}</td>
					<td>@if ($payment->fecha_pago)
						{{Jenssegers\Date\Date::parse($payment->fecha_pago)->format('j M Y')}}
						@endif
					</td>
					<td>{{$payment->inscription->group->startclass->career->nombre}}</td>
					<td>{{$payment->abono}}</td>
					<td>{{$payment->saldo-$payment->abono}}</td>
					<td>{{$payment->saldo}}</td>
					<td>{{$payment->user_id}}</td>
				</tbody>
				@endforeach
			</table>
		</div>
	</div>
</div>
@endforeach
@endsection