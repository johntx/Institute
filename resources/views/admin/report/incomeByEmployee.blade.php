@extends('layouts.admin')
@section('content')
<br>
<div class="form-group">
	{!! Form::label('Fecha de Reporte') !!}
	<div class="col-xs-12" style="padding: 0;">
		<div class="col-xs-6" style="padding-left: 0;">
			{!! Form::text('fecha_inicio',$fecha_inicio,['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd','id'=>'selec_fecha_income']) !!}
		</div>
		<div class="col-xs-6">
			{!!link_to_action('ReportController@incomeByEmployee', $title = 'Cambiar Fecha', $parameters = 'fecha', $attributes = ['class'=>'btn btn-success','id'=>'boton_fecha_income'])!!}
		</div>
	</div>
</div>
<br>
<br>
<?php $total = 0; $total2 = 0; ?>
@foreach($users as $user)
{!! Form::open(['action' => 'PaymentController@recibir']) !!}
<div class="panel @if (sizeof($user->payments()->where('estado','Pagado')->where('fecha_pago',\Carbon\Carbon::parse($fecha_inicio)->format('Y-m-d'))->get()) > 0 )
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
					<th>Recibido</th>
				</thead>
				<?php $subtotal = 0; $subtotal2 = 0; ?>
				<tbody>
					@foreach($user->payments()->where('estado','Pagado')->where('fecha_pago',\Carbon\Carbon::parse($fecha_inicio)->format('Y-m-d'))->get() as $key => $payment)
					<tr>
						<td>{{++$key}}</td>
						<td>{{$payment->id}}</td>
						<td>{{$payment->inscription->people->nombrecompleto()}}</td>
						<td>{{Jenssegers\Date\Date::parse($payment->fecha_pago)->format('j M Y')}}</td>
						<td>{{Jenssegers\Date\Date::parse($payment->created_at)->format('j M Y H:i:s')}}</td>
						<td>{{$payment->inscription->group->startclass->career->nombre}}</td>
						<td><b>{{$payment->abono}}</b></td>
						<td>{{$payment->saldo-$payment->abono}}</td>
						<td>{{$payment->saldo}}</td>
						<td style="text-align: center">
							@if (!$payment->recibido)
							<input type="checkbox" class="check_mediano" monto="{{$payment->abono}}" user="{{$user->id}}" value="{{$payment->id}}" name="recibido[]">
							@else
							✔
							@endif
						</td>
					</tr>
					<?php $subtotal += $payment->abono; ?>
					<?php $total += $payment->abono; ?>
					@endforeach
					@foreach($user->orders()->where('fecha_compra',\Carbon\Carbon::parse($fecha_inicio)->format('Y-m-d'))->get() as $key => $order)
					<tr>
						<td>{{++$key}}</td>
						<td>{{$order->id}}</td>
						<td>{{$order->nombre}}</td>
						<td>{{Jenssegers\Date\Date::parse($order->fecha_compra)->format('j M Y')}}</td>
						<td><b>(VENTA)</b></td>
						<td>{{$order->detalle}}</td>
						<td><b>{{$order->total}}</b></td>
						<td>{{$order->descuento}}</td>
						<td>{{$order->subtotal}}</td>
						<td style="text-align: center">
							@if (!$order->recibido)
							<input type="checkbox" class="check_mediano" monto="{{$order->total}}" user="{{$user->id}}" value="{{$order->id}}" name="venta[]">
							@else
							✔
							@endif
						</td>
					</tr>
					<?php $subtotal += $order->total; ?>
					<?php $total += $order->total; ?>
					@endforeach
					@foreach($user->payments()->where('estado','Pagado')->whereBetween('created_at',array(\Carbon\Carbon::parse($fecha_inicio)->format('Y-m-d 00:00:00'), \Carbon\Carbon::parse($fecha_inicio)->format('Y-m-d 23:59:59')))->where('fecha_pago','!=',\Carbon\Carbon::parse($fecha_inicio)->format('Y-m-d'))->get() as $key => $payment)
					<tr style="background-color: rgba(255,120,0,0.4);">
						<td>{{++$key}}</td>
						<td>{{$payment->id}}</td>
						<td>{{$payment->inscription->people->nombrecompleto()}}</td>
						<td>{{Jenssegers\Date\Date::parse($payment->fecha_pago)->format('j M Y')}}</td>
						<td>{{Jenssegers\Date\Date::parse($payment->created_at)->format('j M Y H:i:s')}}</td>
						<td>{{$payment->inscription->group->startclass->career->nombre}}</td>
						<td><b>{{$payment->abono}}</b></td>
						<td>{{$payment->saldo-$payment->abono}}</td>
						<td>{{$payment->saldo}}</td>
						<td></td>
					</tr>
					<?php $subtotal2 += $payment->abono; ?>
					<?php $total2 += $payment->abono; ?>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="panel-footer">
		<span style="font-size: 24px;">Subtotal: {{$subtotal}}</span>
		@if ($subtotal2>0)
		<br>
		Subtotal: {{$subtotal2}} (registros de otras fechas)
		@endif
		@if ($subtotal>0)
		{!! Form::submit('Recibido',['class'=>'btn-primary btn_me']) !!}
		<span class="{{$user->id}}" style="font-size: 20px; float: right; padding-right: 30px;">Recibir: 0</span>
		@endif
	</div>
</div>
{!! Form::close() !!}
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
