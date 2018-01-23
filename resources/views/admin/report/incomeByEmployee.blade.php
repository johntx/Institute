@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<br>
<?php $total = 0; $total2 = 0; ?>
@foreach($users as $user)
<div class="panel @if (sizeof($user->payments()->where('estado','Pagado')->where('fecha_pago',\Carbon\Carbon::now()->format('Y-m-d'))->get()) > 0 )
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
				<?php $subtotal = 0; $subtotal2 = 0; ?>
				<tbody>
					@foreach($user->payments()->where('estado','Pagado')->where('fecha_pago',\Carbon\Carbon::now()->format('Y-m-d'))->get() as $key => $payment)
					<tr>
						<td>{{++$key}}</td>
						<td>{{$payment->id}}</td>
						<td>{{$payment->inscription->people->nombrecompleto()}}</td>
						<td>{{Jenssegers\Date\Date::parse($payment->fecha_pago)->format('j M Y')}}</td>
						<td>{{Jenssegers\Date\Date::parse($payment->created_at)->format('j M Y H:i:s')}}</td>
						<td>{{$payment->inscription->group->startclass->career->nombre}}</td>
						<td>{{$payment->abono}}</td>
						<td>{{$payment->saldo-$payment->abono}}</td>
						<td>{{$payment->saldo}}</td>
					</tr>
					<?php $subtotal += $payment->abono; ?>
					<?php $total += $payment->abono; ?>
					@endforeach
					@foreach($user->payments()->where('estado','Pagado')->whereBetween('created_at',array(\Carbon\Carbon::now()->format('Y-m-d 00:00:00'), \Carbon\Carbon::now()->format('Y-m-d 23:59:59')))->where('fecha_pago','!=',\Carbon\Carbon::now()->format('Y-m-d'))->get() as $key => $payment)
					<tr style="background-color: rgba(255,120,0,0.4);">
						<td>{{++$key}}</td>
						<td>{{$payment->id}}</td>
						<td>{{$payment->inscription->people->nombrecompleto()}}</td>
						<td>{{Jenssegers\Date\Date::parse($payment->fecha_pago)->format('j M Y')}}</td>
						<td>{{Jenssegers\Date\Date::parse($payment->created_at)->format('j M Y H:i:s')}}</td>
						<td>{{$payment->inscription->group->startclass->career->nombre}}</td>
						<td>{{$payment->abono}}</td>
						<td>{{$payment->saldo-$payment->abono}}</td>
						<td>{{$payment->saldo}}</td>
					</tr>
					<?php $subtotal2 += $payment->abono; ?>
					<?php $total2 += $payment->abono; ?>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="panel-footer">
		<h4>Subtotal: {{$subtotal}}</h4>
		@if ($subtotal2>0)
		<br>
		Subtotal: {{$subtotal2}} (registros de otras fechas)
		@endif
	</div>
</div>
@endforeach
<div class="panel panel-primary">
	<div class="panel-heading">Suma de Totales</div>
	<div class="panel-body">
	<h3>Total: {{$total}}</h3>
	<br>
	@if ($total2>0)
		<h4>Total: {{$total2}} (registros de otras fechas)</h4>
		@endif
	</div>
</div>
@endsection
