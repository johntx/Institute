@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Session::get('functionalities') as $func) {
	if ($func->code=='EORD'){ $editar=true; }
	if ($func->code=='DORD'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Fecha</th>
			<th>Cliente</th>
			<th>Observaciones</th>
			<th>Telefono</th>
			<th>Usuario</th>
			<th>Recibido</th>
			<th>Subtotal</th>
			<th>Total</th>
			<th>Imprimir</th>
			@if ($editar)<th>Editar</th>@endif
			@if ($eliminar)<th>Eliminar</th>@endif
		</thead>
		@foreach($orders as $order)
		@if ($order->cancelled_order)
		<tbody style="background-color: rgba(255,100,0,0.3)">
		@else
		<tbody>
			@endif
			<td>{{$order->id}}</td>
			<td>{{Jenssegers\Date\Date::parse($order->fecha_compra)->format('j M Y')}}</td>
			<td>{{$order->nombre}}</td>
			<td>{{$order->detalle}}</td>
			<td><a href="https://api.whatsapp.com/send?phone=591{{$order->telefono}}" target="_blank">{{$order->telefono}}</a></td>
			<td>{{$order->user->user}}</td>
				<td style="text-align: center;">
				@if ($order->recibido)
				✔
				@endif
				</td>
			<td>Bs. {{number_format($order->subtotal, 2,'.','')}}</td>
			<td><b>Bs. {{number_format($order->total, 2,'.','')}}</b></td>
			<td>
				{!!link_to_action('OrderController@pdf', $title = 'Imprimir', $parameters = $order->id, $attributes = ['class'=>'btn btn-info pdfbtn','code'=>$order->id])!!}
			</td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.order.edit', $title = 'Editar', $parameters = $order->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.order.show', $title = 'Eliminar', $parameters = $order->id, $attributes = ['class'=>'btn btn-danger'])!!}
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
{!!$orders->render()!!}
@endsection