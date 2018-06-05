@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Session::get('functionalities') as $func) {
	if ($func->code=='ESTA'){ $editar=true; }
	if ($func->code=='DSTA'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Fecha de Inicio</th>
			<th>Fecha de Culminación</th>
			<th>Duracion</th>
			<th>Descripcion</th>
			<th>Carrera</th>
			<th>Estado</th>
			<th>Costo</th>
			<th>Sucursal</th>
			<th>Grupos</th>
			@if ($editar)<th>Editar</th>@endif
			@if ($eliminar)<th>Eliminar</th>@endif
		</thead>
		@foreach($startclasses as $startclass)
		<tbody>
			<td>{{$startclass->id}}</td>
			<td>{{Jenssegers\Date\Date::parse($startclass->fecha_inicio)->format('j M Y')}}</td>
			<td>{{Jenssegers\Date\Date::parse($startclass->fecha_fin)->format('j M Y')}}</td>
			<td>{{$startclass->duracion}} Mes/s</td>
			<td>{{$startclass->descripcion}}</td>
			<td>{{$startclass->career->nombre}}</td>
			<td>{{$startclass->estado}}</td>
			<td>{{$startclass->costo}}</td>
			<td>{{$startclass->office->nombre}}</td>
			<td>
				{!!link_to_action('ReportController@group', $title = 'Grupos', $parameters = $startclass->id, $attributes = ['class'=>'btn btn-info'])!!}
			</td>
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