@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Auth::user()->role->functionalities as $func) {
	if ($func->code=='ESTA'){ $editar=true; }
	if ($func->code=='DSTA'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Fecha de Inicio</th>
			<th>Carrera</th>
			<th>Turno</th>
			<th>Estado</th>
			@if ($editar)<th>Editar</th>@endif
			@if ($eliminar)<th>Eliminar</th>@endif
		</thead>
		@foreach($groups as $group)
		<tbody>
			<td>{{$group->id}}</td>
			<td>{{$group->startclass->fecha_inicio}}</td>
			<td>{{$group->startclass->career->nombre}}</td>
			<td>{{$group->turno}}</td>
			<td>({{$group->estado}})</td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.group.edit', $title = 'Editar', $parameters = $group->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.group.show', $title = 'Borrar', $parameters = $group->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$groups->render()!!}
@endsection