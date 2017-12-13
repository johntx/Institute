@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
<table class="table table-hover">
	<thead>
		<th>Id</th>
		<th>Cliente</th>
		<th>Pagó</th>
		<!--th>Fecha Pagar</th-->
		<th>Carrera</th>
		<th>Abono</th>
		<th>Saldo</th>
		<th>Observacion</th>
		<th>Usuario</th>
		<th>Option</th>
	</thead>
	@foreach($payments as $payment)
	<tbody>
		<td>{{$payment->id}}</td>
		<td>{{$payment->inscription->people->nombrecompleto()}}</td>
		<td>{{$payment->fecha_pago}}</td>
		<!--td>{!{$payment->fecha_pagar}!}</td-->
		<td>{{$payment->inscription->career->nombre}}</td>
		<td>{{$payment->abono}}</td>
		<td>{{$payment->saldo}}</td>
		<td>{{$payment->observacion}}</td>
		<td>{{$payment->user}}</td>
		@foreach(Auth::user()->role->functionalities as $func)
		@if ($func->code=='DPAY' && $payment->abono != 0)
		<td>
			{!!link_to_route('admin.payment.show', $title = 'Borrar', $parameters = $payment->id, $attributes = ['class'=>'btn btn-danger'])!!}
		</td>
		@endif
		@endforeach
	</tbody>
	@endforeach
</table>
</div>
{!!$payments->render()!!}
@endsection