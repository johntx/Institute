@extends('layouts.admin')
@section('content')
<div class="table-responsive">
	<table class="table table-hover table-condensed">
		<thead>
			<th>Id</th>
			<th>Cliente</th>
			<th>Pagó</th>
			<th>Registro</th>
			<th>Carrera</th>
			<th>Abono</th>
			<th>Saldo</th>
			<th>Total</th>
			<th>Recibido</th>
		</thead>
		<tbody>
			@foreach($payments as $payment)
			<tr>
				<td>{{$payment->id}}</td>
				<td><a target="_blank" href="{{url('admin/student/search/'.$payment->inscription->people->id)}}" style="color: #0800AB">{{$payment->inscription->people->nombrecompleto()}}</a></td>
				<td>{{Jenssegers\Date\Date::parse($payment->fecha_pago)->format('j M Y')}}</td>
				<td>{{Jenssegers\Date\Date::parse($payment->created_at)->format('j M Y H:i:s')}}</td>
				<td>{{$payment->inscription->group->startclass->career->nombre}}</td>
				<td style="text-align: center;"><b>{{$payment->abono}}</b></td>
				<td>{{$payment->saldo-$payment->abono}}</td>
				<td>{{$payment->saldo}}</td>
				<td style="text-align: center;">
					@if ($payment->recibido)
					✔
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
{!!$payments->render()!!}
@endsection
