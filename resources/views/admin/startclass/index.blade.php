@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<?php $editar=false; $eliminar=false; ?>
@foreach(Auth::user()->role->functionalities as $func)
@if ($func->code=='ESTA')
<?php $editar=true; ?>
@endif
@if ($func->code=='DSTA')
<?php $eliminar=true; ?>
@endif
@endforeach
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
			<td>{{Jenssegers\Date\Date::parse($startclass->fecha_inicio)->format('j M Y')}}</td>
			<td>{{Jenssegers\Date\Date::parse($startclass->fecha_fin)->format('j M Y')}}</td>
			<td>{{$startclass->career->nombre}}</td>
			<td>{{$startclass->estado}}</td>
			<td>{{$startclass->office->nombre}}</td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.startclass.edit', $title = 'Editar', $parameters = $startclass->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.startclass.show', $title = 'Borrar', $parameters = $startclass->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$startclasses->render()!!}
@endsection