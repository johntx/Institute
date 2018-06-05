@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Session::get('functionalities') as $func) {
	if ($func->code=='EOFF'){ $editar=true; }
	if ($func->code=='DOFF'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Nombre</th>
			<th>Direccion</th>
			@if ($editar)<th>Editar</th>@endif
			@if ($eliminar)<th>Eliminar</th>@endif
		</thead>
		@foreach($offices as $office)
		<tbody>
			<td>{{$office->id}}</td>
			<td>{{$office->nombre}}</td>
			<td>{{$office->direccion}}</td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.office.edit', $title = 'Editar', $parameters = $office->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.office.show', $title = 'Borrar', $parameters = $office->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$offices->render()!!}
@endsection