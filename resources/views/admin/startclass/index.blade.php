@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false; $ext=false;
foreach (Session::get('functionalities') as $func) {
	if ($func->code=='ESTA'){ $editar=true; }
	if ($func->code=='DSTA'){ $eliminar=true; }
}
if (Auth::user()->role->code=='EXT'){
	$ext=true;
}
?>
<div class="table-responsive">
	<table class="table table-hover tablaNoOrder compact">
		<thead>
			<th>Carrera</th>
			<th>Inicia</th>
			<th>Culmina</th>
			<th>Duracion</th>
			<th>Precio</th>
			<th>Estado</th>
			<th>Descripcion</th>
			<th>Sucursal</th>
			@if (!$ext)<th>Grupos</th>@endif
			@if ($editar)<th>Editar</th>@endif
			@if ($eliminar)<th>Eliminar</th>@endif
		</thead>
		<tbody>
			@foreach($startclasses as $startclass)
			<tr>
				<td>{{$startclass->career->nombre}}</td>
				<td>{{Jenssegers\Date\Date::parse($startclass->fecha_inicio)->format('j M Y')}}</td>
				<td>{{Jenssegers\Date\Date::parse($startclass->fecha_fin)->format('j M Y')}}</td>
				<td>{{$startclass->duracion}} Mes/s</td>
				<td>{{$startclass->costo}}</td>
				<td>{{$startclass->estado}}</td>
				<td>{{$startclass->descripcion}}</td>
				<td>{{$startclass->office->nombre}}</td>
				@if (!$ext)
				<td>
					{!!link_to_action('ReportController@group', $title = 'Grupos', $parameters = $startclass->id, $attributes = ['class'=>'btn btn-info'])!!}
				</td>
				@endif
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
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
{!!$startclasses->render()!!}
@endsection