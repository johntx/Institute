@extends('layouts.admin')
@section('content')
<?php $eliminar=false;
foreach (Session::get('functionalities') as $func) {
	if ($func->code=='DPAY'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover table-condensed">
		<thead>
			<th>Id</th>
			<th>Cliente</th>
			<th>Pagó</th>
			@if (Auth::user()->role->code == 'ADM')
			<th>Registro</th>
			@endif
			<th>Carrera</th>
			<th>Abono</th>
			<th>Saldo</th>
			<th>Total</th>
			@if (Auth::user()->role->id <= 2)
			<th>Usuario</th>
			@endif
			<th>Imprimir</th>
			@if ($eliminar)<th>Eliminar</th>@endif
		</thead>
		@foreach($payments as $payment)
		<tbody>
			<td>{{$payment->id}}</td>
			<td>{{$payment->inscription->people->nombrecompleto()}}</td>
			<td>@if ($payment->fecha_pago)
				{{Jenssegers\Date\Date::parse($payment->fecha_pago)->format('j M Y')}}
				@endif
			</td>
			@if (Auth::user()->role->code == 'ADM')
			<td>{{Jenssegers\Date\Date::parse($payment->created_at)->format('j M Y H:i:s')}}</td>
			@endif
			<td>{{$payment->inscription->group->startclass->career['nombre']}}</td>
			<td>{{$payment->abono}}</td>
			<td>{{$payment->saldo-$payment->abono}}</td>
			<td>{{$payment->saldo}}</td>
			@if (Auth::user()->role->id <= 2)
			<td>{{$payment->user}}</td>
			@endif
			@if ($payment->abono != 0)
			<td>
				{!!link_to_action('PaymentController@pdf', $title = 'Imprimir', $parameters = $payment->id, $attributes = ['class'=>'btn btn-info pdfbtn','code'=>$payment->id])!!}
			</td>
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.payment.show', $title = 'Borrar', $parameters = $payment->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
			@endif
		</tbody>
		@endforeach
	</table>
</div>
<div class="modal fade" id="pdfModal" tabindex="0" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document" style="z-index: 2000">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">RECIBO</h4>
			</div>
			<div style="text-align: center;">
				<iframe src="" style="width:100%; height:80%;" frameborder="0"></iframe>
			</div>
		</div>
	</div>
</div>
{!!$payments->render()!!}
@endsection