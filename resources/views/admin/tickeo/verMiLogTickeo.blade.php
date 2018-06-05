@extends('layouts.admin')
@section('content')
<div class="table-responsive">
	<table class="table table-hover">
		<tr>
			<th>Nombre</th>
			<th>Fecha y Hora</th>
			<th>tipo</th>
			<th>Día</th>
			<th>Estado</th>
			@if (Auth::user()->role->code == "ADM" || Auth::user()->role->code == "ROOT")
			<th>Validar / Invalidar</th>
			@endif
			<th>Cancelado</th>
		</tr>
		<?php $fecha1=\Carbon\Carbon::parse($tickeos[0]->fecha)->format('Y-m-d'); $fecha2=null; $b=true; ?>
		@foreach($tickeos as $k=>$tickeo)
		<?php $fecha2=\Carbon\Carbon::parse($tickeo->fecha)->format('Y-m-d');
		if ($fecha2!=$fecha1 && $b) {
			$b=false;
		} elseif ($fecha2!=$fecha1 && !$b) {
			$b=true;
		}
		if ($k+1 < count($tickeos)) {
			$fecha2 = \Carbon\Carbon::parse($tickeos[$k+1]->fecha)->format('Y-m-d');
		}
		$fecha1 = \Carbon\Carbon::parse($tickeos[$k]->fecha)->format('Y-m-d');
		?>
		<tr @if ($b) style="background-color: #E2E2E2;"@endif @if ($tickeo->estado == 'invalido') style="background-color: #D98181;"@endif @if ($tickeo->estado == 'creado') style="background-color: #B8B1FE;"@endif>
			<td>{{$tickeo->biometric->nombre}}</td>
			<td>{{Jenssegers\Date\Date::parse($tickeo->fecha)->format('j M Y - H:i:s')}}</td>
			<td>@if ($tickeo->tipo == 0) entrada @else salida @endif</td>
			<td>{{$tickeo->dia}}</td>
			<td>
				@if (!$tickeo->estado && !$tickeo->cancelado)
				{!!link_to_action('TickeoController@observar', $title = 'Observar', $parameters = $tickeo->id, $attributes = ['class'=>'btn btn-warning observar'])!!}
				@else
				{{$tickeo->estado}}
				@endif
			</td>
			@if (Auth::user()->role->code == "ADM" || Auth::user()->role->code == "ROOT")
			<td>
				{!! Form::open(['route' => ['admin.tickeo.update',$tickeo->id],'method'=>'put','style'=>"margin:0;"]) !!}
				<input type="hidden" name="url" value="{{$_SERVER['REQUEST_URI']}}" >
				@if ($tickeo->estado == "invalido")
				{!! Form::submit('Validar',['class'=>'btn btn-success']) !!}
				@else
				{!! Form::submit('Invalidar',['class'=>'btn btn-danger']) !!}
				@endif
				{!! Form::close() !!}
			</td>
			@endif
			<td>
				@if ($tickeo->cancelado)
				CANCELADO
				@endif
			</td>
		</tr>
		@endforeach
	</table>
</div>
@endsection