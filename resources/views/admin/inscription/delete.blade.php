@extends('layouts.admin')
@section('content')
@include('alerts.request')
<br>
<div class="panel panel-danger">
	<div class="panel-heading">DATOS DE INSCRIPCIÓN - CARRERA ({{$inscription->group->startclass->career->nombre}}) (Eliminar)</div>
	<div class="panel-body">
		<p class="col-sm-6"><b>Id:</b> {{$inscription->id }}</p>
		<p class="col-sm-6"><em><b>Usuario:</b> ({{$inscription->user->user }}) {{$inscription->user->people->nombrecompleto() }}</em></p>
		<p class="col-sm-6"><b>Estado:</b> {{$inscription->estado }}</p>
		<p class="col-sm-6"><b>Pago por mes:</b> {{$inscription->monto }}</p>
		<p class="col-sm-6"><b>Carrera:</b> {{$inscription->group->startclass->career->nombre }}</p>
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
	</div>
	<div class="table-responsive">
		<table class="table table-hover">
			<thead style="background-color: #f2dede;">
				<th>Id</th>
				<th>Fecha Pagar</th>
				<th>Pagó</th>
				@if (Auth::user()->role->code == 'ADM')
				<th>Registro</th>
				@endif
				<th>Abono</th>
				<th>Saldo</th>
				<th>Total</th>
				<th>Estado</th>
				<th>Obser.</th>
				<th><em>Usuario</em></th>
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
				@if (Auth::user()->role->code == 'ADM' && $payment->abono != 0)
				<td>
					{{Jenssegers\Date\Date::parse($payment->created_at)->format('j M Y H:i:s')}}
				</td>
				@endif
				<td>
					@if ($payment->abono != 0)
					{{$payment->abono}}
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
					@if ($payment->abono != 0)
					<em>{{\Institute\User::find($payment->user_id)->user}}</em>
					@endif
				</td>
			</tbody>
			@endforeach
		</table>
	</div>
</div>
{!! Form::open(['route' => ['admin.inscription.destroy',$inscription->id],'method'=>'delete']) !!}
{!! Form::submit('Eliminar Inscripcion',['class'=>'btn btn-danger']) !!}
{!! Form::close() !!}
@endsection