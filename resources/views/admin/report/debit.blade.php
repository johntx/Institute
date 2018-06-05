@extends('layouts.admin')
@section('content')
<div class="table-responsive">
	<table class="table table-hover tablaNoOrder compact">
		<thead>
			<th>Nombre</th>
			<th>Carrera</th>
			<th>Grupo</th>
			<th>Inicio <br>Esperado</th>
			<th>Inicio <br>Real</th>
			<th>Fecha Pagar</th>
			<th>Saldo</th>
			<th>Telefono</th>
			<th>Opción</th>
		</thead>
		<tbody>
			@foreach($payments as $payment)
			@if (strtotime($payment->fecha_pagar) < strtotime(\Carbon\Carbon::now()))
			<tr class="danger">
				@else <tr>
				@endif
				<?php
				if($payment->inscription->fecha_ingreso > $payment->inscription->group->startclass->fecha_inicio)
					$fecha_ingreso=$payment->inscription->fecha_ingreso;
				else
					$fecha_ingreso=$payment->inscription->group->startclass->fecha_inicio;
				?>
				<td>{{$payment->inscription->people->nombrecompleto()}}</td>
				<td>{{$payment->inscription->group->startclass->career->nombre}}</td>
				<td>{{$payment->inscription->group->turno}}</td>
				<td>{{ Jenssegers\Date\Date::parse($payment->inscription->group->startclass->fecha_inicio)->format('j M Y')}}</td>
				<td>{{ Jenssegers\Date\Date::parse($fecha_ingreso)->format('j M Y')}}</td>
				<td>
					<b>{{ Jenssegers\Date\Date::parse($payment->fecha_pagar)->format('j M Y')}}</b>
				</td>
				<td>{{$payment->saldo}}</td>
				<td><a href="https://api.whatsapp.com/send?phone=591{{$payment->inscription->people->telefono}}" target="_blank">{{$payment->inscription->people->telefono}}</a></td>
				<td>
					{!! Form::open(['route' => ['admin.inscription.destroy',$payment->inscription->id],'method'=>'delete']) !!}
					{!! Form::submit('Retirar',['class'=>'btn btn-danger']) !!}
					{!! Form::close() !!}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection