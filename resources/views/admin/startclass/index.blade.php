@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Fecha de Inicio</th>
			<th>Fecha de Culminación</th>
			<th>Carrera</th>
			<th>Estado</th>
			<th>Sucursal</th>
			<th>Edit</th>
		</thead>
		@foreach($startclasses as $startclass)
		<tbody>
			<td>{{$startclass->id}}</td>
			<td>{{\Carbon\Carbon::parse($startclass->fecha_inicio)->format('d/m/Y')}}</td>
			<td>{{\Carbon\Carbon::parse($startclass->fecha_fin)->format('d/m/Y')}}</td>
			<td>{{$startclass->career->nombre}}</td>
			<td>{{$startclass->estado}}</td>
			<td>{{$startclass->office->nombre}}</td>
			@foreach(Auth::user()->role->functionalities as $func)
			@if ($func->code=='ESTA')
			<td>
				{!!link_to_route('admin.startclass.edit', $title = 'Editar', $parameters = $startclass->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($func->code=='DSTA')
			<td>
				{!!link_to_route('admin.startclass.show', $title = 'Borrar', $parameters = $startclass->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
			@endforeach
		</tbody>
		@endforeach
	</table>
</div>
{!!$startclasses->render()!!}
@endsection