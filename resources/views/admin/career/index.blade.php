@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Session::get('functionalities') as $func) {
	if ($func->code=='ECAR'){ $editar=true; }
	if ($func->code=='DCAR'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Nombre</th>
			<th>Color</th>
			<th>Asignaturas</th>
			@if ($editar)<th>Editar</th>@endif
			@if ($eliminar)<th>Eliminar</th>@endif
		</thead>
		@foreach($careers as $career)
		<tbody>
			<td>{{$career->id}}</td>
			<td>{{$career->nombre}}</td>
			<td><div class="btn-group"><button type="button" class="btn" style="background-color: {{$career->color}}; color: {{$career->texto}};">color</button></div></td>
			<td>
				@foreach($career->subjects()->orderBy('nombre','asc')->get() as $subject)
				[{{$subject->nombre}}] - 
				@endforeach
			</td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.career.edit', $title = 'Editar', $parameters = $career->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.career.show', $title = 'Borrar', $parameters = $career->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$careers->render()!!}
@endsection