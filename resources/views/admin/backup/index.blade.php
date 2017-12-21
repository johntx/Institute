@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Fecha de Inicio</th>
			<th>Carrera</th>
			<th>Turno</th>
			<th>Estado</th>
			<th>Edit</th>
		</thead>
		@foreach($groups as $group)
		<tbody>
			<td>{{$group->id}}</td>
			<td>{{$group->startclass->fecha_inicio}}</td>
			<td>{{$group->startclass->career->nombre}}</td>
			<td>{{$group->turno}}</td>
			<td>({{$group->estado}})</td>
			@foreach(Auth::user()->role->functionalities as $func)
			@if ($func->code=='ESTA')
			<td>
				{!!link_to_route('admin.group.edit', $title = 'Editar', $parameters = $group->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($func->code=='DSTA')
			<td>
				{!!link_to_route('admin.group.show', $title = 'Borrar', $parameters = $group->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
			@endforeach
		</tbody>
		@endforeach
	</table>
</div>
{!!$groups->render()!!}
@endsection