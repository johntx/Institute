@extends('layouts.admin')
@section('content')
@include('alerts.request')
<?php $eliminar=false;?>
@foreach(Auth::user()->role->functionalities as $func)
@if ($func->code=='DPAY')
<?php $eliminar=true; ?>
@endif
@endforeach
<br>
<div class="panel panel-info">
	<div class="panel-heading">DATOS DEL ESTUDIANTE</div>
	<div class="panel-body">
		<p class="col-sm-6"><b>Usuario:</b> {{$student->user->user }}</p>
		<p class="col-sm-6"><b>CI:</b> {{$student->ci }}</p>
		<p class="col-sm-6"><b>Nombre:</b> {{$student->nombrecompleto() }}</p>
		<p class="col-sm-6"><b>Fecha de Nacimiento:</b> {{ Jenssegers\Date\Date::parse($student->fecha_nacimiento)->format('j M Y') }}</p>
		<p class="col-sm-6"><b>Telefono:</b> {{$student->telefono }}</p>
	</div>
</div>
@foreach ($student->inscriptions as $inscription)
<div class="panel panel-success">
	<div class="panel-heading">DATOS DE INSCRIPCIÓN - CARRERA ({{$inscription->group->startclass->career->nombre}})</div>
	<div class="panel-body">
		<p class="col-sm-6"><b>Id:</b> {{$inscription->id }}</p>
		<p class="col-sm-6">&nbsp;</p>
		<p class="col-sm-6"><b>Estado:</b> {{$inscription->estado }}</p>
		<p class="col-sm-6"><b>Pago por mes:</b> {{$inscription->monto }}</p>
		<p class="col-sm-6"><b>Carrera:</b> {{$inscription->group->startclass->career->nombre }}</p>
		<p class="col-sm-6"><b>Total pagado:</b> {{$inscription->abono }}</p>
		<p class="col-sm-6"><b>Grupo:</b> {{$inscription->group->turno }}</p>
		<p class="col-sm-6"><b>Total a pagar:</b> {{$inscription->total }}</p>
		<p class="col-sm-6"><b>Fecha Ingreso:</b> {{Jenssegers\Date\Date::parse($inscription->fecha_ingreso)->format('j M Y')}}</p>
		<p class="col-sm-6">
			@if ($inscription->fecha_retiro != null)
			<b>Fecha Retiro:</b> {{Jenssegers\Date\Date::parse($inscription->fecha_retiro)->format('j M Y') }}
			@endif
			&nbsp;
		</p>
		<p class="col-sm-6"><b>Fecha inicio de clases:</b> {{Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_inicio)->format('j M Y')}}</p>
		<p class="col-sm-6"><b>Fecha fin de clases:</b> {{Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_fin)->format('j M Y')}}</p>
	</div>
	<div class="table-responsive">
		<table class="table table-hover">
			<thead style="background-color: #EEEEEE;">
				<th>Id</th>
				<th>Fecha Pagar</th>
				<th>Pagó</th>
				<th>Abono</th>
				<th>Saldo</th>
				<th>Estado</th>
				<th>Observaciones</th>
				<th>Opción</th>
			</thead>
			@foreach ($inscription->payments()->orderBy('id','DESC')->get() as $payment)
			<tbody>
				<td>{{$payment->id}}</td>
				<td>{{Jenssegers\Date\Date::parse($payment->fecha_pagar)->format('j M Y')}}</td>
				<td>
					@if ($payment->fecha_pago != null)
					{{Jenssegers\Date\Date::parse($payment->fecha_pago)->format('j M Y')}}
					@endif
				</td>
				<td>
					@if ($payment->abono != 0)
					{{$payment->abono}}
					@endif
				</td>
				<td>{{$payment->saldo}}</td>
				<td>{{$payment->estado}}</td>
				<td>{{$payment->observacion}}</td>
				@if ($payment->abono != 0)
				<td>
				@if ($eliminar)
					{!!link_to_route('admin.payment.show', $title = 'Borrar', $parameters = $payment->id, $attributes = ['class'=>'btn btn-danger'])!!}
				@endif
					{!!link_to_action('PaymentController@pdf', $title = 'Imprimir', $parameters = $payment->id, $attributes = ['class'=>'btn btn-info pdfbtn','code'=>$payment->id])!!}
				</td>
				@endif
			</tbody>
			@endforeach
		</table>
	</div>
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
@endforeach

@endsection