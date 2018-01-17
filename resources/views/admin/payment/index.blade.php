@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<?php $eliminar=false;?>
@foreach(Auth::user()->role->functionalities as $func)
@if ($func->code=='DPAY')
<?php $eliminar=true; ?>
@endif
@endforeach
<div class="table-responsive">
	<table class="table table-hover table-condensed">
		<thead>
			<th>Id</th>
			<th>Cliente</th>
			<th>Pagó</th>
			<!--th>Fecha Pagar</th-->
			<th>Carrera</th>
			<th>Abono</th>
			<th>Saldo</th>
			<th>Total</th>
			<th>Usuario</th>
			<th>Option</th>
		</thead>
		@foreach($payments as $payment)
		<tbody>
			<td>{{$payment->id}}</td>
			<td>{{$payment->inscription->people->nombrecompleto()}}</td>
			<td>@if ($payment->fecha_pago)
				{{Jenssegers\Date\Date::parse($payment->fecha_pago)->format('j M Y')}}
				@endif
			</td>
			<!--td>{!{$payment->fecha_pagar}!}</td-->
			<td>{{$payment->inscription->group->startclass->career->nombre}}</td>
			<td>{{$payment->abono}}</td>
			<td>{{$payment->saldo-$payment->abono}}</td>
			<td>{{$payment->saldo}}</td>
			<td>{{$payment->user}}</td>
			@if ($payment->abono != 0)
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.payment.show', $title = 'Borrar', $parameters = $payment->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
			<td>
				{!!link_to_action('PaymentController@pdf', $title = 'Imprimir', $parameters = $payment->id, $attributes = ['class'=>'btn btn-info pdfbtn','code'=>$payment->id])!!}
			</td>
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