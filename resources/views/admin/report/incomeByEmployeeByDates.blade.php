@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<br>
@foreach($users as $user)
<div class="panel @if (sizeof($user->payments()->where('estado','Pagado')->whereBetween('fecha_pago',array($fecha_inicio, $fecha_fin))->get()) > 0 )
	panel-primary
	@else
	panel-info
	@endif">
	<div class="panel-heading">{{$user->people->nombrecompleto()}}</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-hover table-condensed">
				<thead>
					<th>No</th>
					<th>Id</th>
					<th>Cliente</th>
					<th>Pagó</th>
					<th>Registro</th>
					<th>Carrera</th>
					<th>Abono</th>
					<th>Saldo</th>
					<th>Total</th>
				</thead>
				<?php $subtotal = 0; ?>
				@foreach($user->payments()->where('estado','Pagado')->whereBetween('fecha_pago',array($fecha_inicio, $fecha_fin))->get() as $key => $payment)
				<tbody>
					<td>{{++$key}}</td>
					<td>{{$payment->id}}</td>
					<td>{{$payment->inscription->people->nombrecompleto()}}</td>
					<td>{{Jenssegers\Date\Date::parse($payment->fecha_pago)->format('j M Y')}}</td>
					<td>{{Jenssegers\Date\Date::parse($payment->created_at)->format('j M Y H:i:s')}}</td>
					<td>{{$payment->inscription->group->startclass->career->nombre}}</td>
					<td>{{$payment->abono}}</td>
					<td>{{$payment->saldo-$payment->abono}}</td>
					<td>{{$payment->saldo}}</td>
				</tbody>
				<?php $subtotal += $payment->abono; ?>
				@endforeach
				@foreach($user->payments()->where('estado','Pagado')->whereBetween('created_at',array(Jenssegers\Date\Date::parse($fecha_inicio)->format('Y-m-d 00:00:00'), Jenssegers\Date\Date::parse($fecha_fin)->format('Y-m-d 23:59:59')))->get() as $key => $payment)
				<tbody>
					<td>{{++$key}}</td>
					<td>{{$payment->id}}</td>
					<td>{{$payment->inscription->people->nombrecompleto()}}</td>
					<td>{{Jenssegers\Date\Date::parse($payment->fecha_pago)->format('j M Y')}}</td>
					<td>{{Jenssegers\Date\Date::parse($payment->created_at)->format('j M Y H:i:s')}}</td>
					<td>{{$payment->inscription->group->startclass->career->nombre}}</td>
					<td>{{$payment->abono}}</td>
					<td>{{$payment->saldo-$payment->abono}}</td>
					<td>{{$payment->saldo}}</td>
				</tbody>
				<?php $subtotal += $payment->abono; ?>
				@endforeach
			</table>
		</div>
	</div>
	<div class="panel-footer">
		Subtotal: {{$subtotal}}
	</div>
</div>
@endforeach
@endsection