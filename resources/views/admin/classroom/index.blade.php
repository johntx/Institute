@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Session::get('functionalities') as $func) {
	if ($func->code=='ECLA'){ $editar=true; }
	if ($func->code=='DCLA'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Area</th>
			<th>Piso</th>
			<th>Aula</th>
			<th>Sucursal</th>
			@if ($editar)<th>Editar</th>@endif
			@if ($eliminar)<th>Eliminar</th>@endif
		</thead>
		@foreach($classrooms as $classroom)
		<tbody>
			<td>{{$classroom->id}}</td>
			<td>{{$classroom->area}}</td>
			<td>{{$classroom->piso}}</td>
			<td>{{$classroom->aula}}</td>
			<td>{{$classroom->office->nombre}}</td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.classroom.edit', $title = 'Editar', $parameters = $classroom->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.classroom.show', $title = 'Borrar', $parameters = $classroom->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$classrooms->render()!!}
@endsection