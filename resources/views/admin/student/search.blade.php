@extends('layouts.admin')
@section('content')
@include('alerts.request')
<?php $eliminar=false;?>
@foreach(Session::get('functionalities') as $func)
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
		<p class="col-sm-6"><b>Telefono:</b> <a href="https://api.whatsapp.com/send?phone=591{{$student->telefono}}" target="_blank">{{$student->telefono}}</a></p>
		<p class="col-sm-6"><b>Telefono Padres:</b> {{$student->telefono2 }}</p>
		<p class="col-sm-6"><b>Como Se Enteró del Instituto:</b> {{$student->encuesta}}</p>
		<p class="col-sm-6"><b>Observaciones:</b> {{$student->observacion}}</p>
		<p class="col-sm-6">{!!link_to_route('admin.student.edit', $title = 'Editar Estudiante', $parameters = $student->id, $attributes = ['class'=>'btn btn-primary'])!!}</p>
	</div>
</div>
@foreach ($student->inscriptions as $inscription)
<div class="panel panel-success">
	<div class="panel-heading">DATOS DE INSCRIPCIÓN - CARRERA ({{$inscription->group->startclass->career->nombre}})</div>
	<div class="panel-body">
		<p class="col-sm-6"><b>Id:</b> {{$inscription->id }}</p>
		<p class="col-sm-6"><em><b>Usuario:</b> ({{$inscription->user->user }}) {{$inscription->user->people->nombrecompleto() }}</em></p>
		<p class="col-sm-6"><b>Estado:</b> {{$inscription->estado }}</p>
		<p class="col-sm-6">&nbsp;</p>
		<p class="col-sm-6"><b>Carrera:</b> {{$inscription->group->startclass->career->nombre }}</p>
		<p class="col-sm-6"><b>Pago por mes:</b> {{$inscription->monto }}</p>
		<p class="col-sm-6"><b>Carrera que postula:</b> {{$inscription->people->carrera }}</p>
		<p class="col-sm-6"><b>Total pagado:</b> {{$inscription->abono }}</p>
		<p class="col-sm-6"><b>Grupo:</b> {{$inscription->group->turno }}</p>
		<p class="col-sm-6"><b>Total a cancelar:</b> {{$inscription->total }}</p>
		<p class="col-sm-6"><b>Fecha Ingreso:</b> {{Jenssegers\Date\Date::parse($inscription->fecha_ingreso)->format('j M Y')}}</p>
		<p class="col-sm-6">
			@if ($inscription->fecha_retiro != null)
			<b>Fecha Retiro:</b> {{Jenssegers\Date\Date::parse($inscription->fecha_retiro)->format('j M Y') }}
			@endif
			&nbsp;
		</p>
		<p class="col-sm-6"><b>Fecha inicio de clases:</b> {{Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_inicio)->format('j M Y')}}</p>
		<p class="col-sm-6"><b>Fecha fin de clases:</b> {{Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_fin)->format('j M Y')}}</p>
		<p class="col-sm-6"><b>Cursos extras:</b>@foreach ($inscription->extras as $extra){{$extra->nombre}}, @endforeach</p>
		<p>{!!link_to_action('AssistanceController@ver', $title = 'Asistencias', $parameters = $inscription->group->id, $attributes = ['class'=>'btn btn-warning'])!!}</p>
	</div>
	<div class="table-responsive">
		<table class="table table-hover">
			<thead style="background-color: #EEEEEE;">
				<th>Id</th>
				<th>Fecha Pagar</th>
				<th>Pagó</th>
				@if (Auth::user()->role->code == 'ADM')
				<th>Registro</th>
				@endif
				<th>Abono</th>
				<th>Desc</th>
				<th>Saldo</th>
				<th>Total</th>
				<th>Estado</th>
				<th>Obser.</th>
				<th><em>Usuario</em></th>
				<th>Imprimir</th>
				@if ($eliminar)
				<th>Eliminar</th>
				@endif
			</thead>
			<tbody>
				@foreach ($inscription->payments()->orderBy('id','DESC')->get() as $payment)
				<tr @if ($inscription->abono == $inscription->total)
					style="background-color: rgba(0,200,200,0.2);"
					@elseif ($inscription->debit())
					style="background-color: rgba(255,0,0,0.4);"
					@elseif ($inscription->debitNext())
					style="background-color: rgba(255,255,0,0.6);"
					@else
					style="background-color: rgba(0,255,0,0.6);"
					@endif >
					<td>{{$payment->id}}</td>
					<td>{{Jenssegers\Date\Date::parse($payment->fecha_pagar)->format('j M Y')}}</td>
					<td>
						@if ($payment->fecha_pago != null)
						{{Jenssegers\Date\Date::parse($payment->fecha_pago)->format('j M Y')}}
						@endif
					</td>
					<td>
						@if (Auth::user()->role->code == 'ADM' && $payment->abono != 0)
						{{Jenssegers\Date\Date::parse($payment->created_at)->format('j M Y H:i:s')}}
						@endif
					</td>
					<td>
						@if ($payment->abono != 0)
						{{$payment->abono}}
						@endif
						@if ($payment->descuento > 0)
						{{$payment->abono}}
						@endif
					</td>
					<td>
						@if ($payment->descuento > 0)
						{{$payment->descuento}}
						@endif
					</td>
					<td>
						@if ($payment->abono != 0)
						{{$payment->saldo-$payment->abono}}
						@endif
					</td>
					<td>{{$payment->saldo}}</td>
					<td>{{$payment->estado}}</td>
					<td>{{$payment->observacion}}</td>
					<td>
						<em>{{\Institute\User::find($payment->user_id)['user']}}</em>
					</td>
					<td>
						@if ($payment->abono != 0)
						{!!link_to_action('PaymentController@pdf', $title = 'Imprimir', $parameters = $payment->id, $attributes = ['class'=>'btn btn-info pdfbtn','code'=>$payment->id])!!}
						@endif
					</td>
					<td>
						@if ($payment->abono != 0)
						@if ($eliminar)
						{!!link_to_route('admin.payment.show', $title = 'Borrar', $parameters = $payment->id, $attributes = ['class'=>'btn btn-danger'])!!}
						@endif
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
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