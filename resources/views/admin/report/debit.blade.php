@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	<table class="table table-hover table-condensed">
		<thead>
			<th>Nombre</th>
			<th>Carrera</th>
			<th>Inicio</th>
			<th>Fecha Pagar</th>
			<th>Saldo</th>
			<th>Telefono</th>
			<th>Opción</th>
		</thead>
		@foreach($payments as $payment)
		@if (strtotime($payment->fecha_pagar) < strtotime(\Carbon\Carbon::now()))
		<tbody style="background-color: rgba(255,100,0,0.3)">
			@else
			<tbody>
				@endif
				<td>{{$payment->inscription->people->nombrecompleto()}}</td>
				<td>{{$payment->inscription->group->startclass->career->nombre}}</td>
				<td>{{ \Carbon\Carbon::parse($payment->inscription->group->startclass->fecha_inicio)->format('d/m/y')}}</td>
				<td>
					<b>{{ \Carbon\Carbon::parse($payment->fecha_pagar)->format('d/m/y')}}</b>
				</td>
				<td>{{$payment->saldo}}</td>
				<td>{{$payment->inscription->people->telefono}}</td>
				<td>
				{!! Form::open(['route' => ['admin.inscription.destroy',$payment->inscription->id],'method'=>'delete']) !!}
					{!! Form::submit('Retirar',['class'=>'btn btn-danger']) !!}
					{!! Form::close() !!}
				</td>
			</tbody>
			@endforeach
		</table>
	</div>
	@endsection