@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Auth::user()->role->functionalities as $func) {
	if ($func->code=='EEMP'){ $editar=true; }
	if ($func->code=='DEMP'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>CI</th>
			<th>Nombre</th>
			<th>Rol</th>
			<th>Telefono</th>
			<th>Fecha Nacimiento</th>
			<th>Tickeo</th>
			@if ($editar)<th>Editar</th>@endif
			@if ($eliminar)<th>Eliminar</th>@endif
		</thead>
		@foreach($employees as $employee)
		<tbody>
			<td>{{$employee->ci}}</td>
			<td>{{$employee->nombrecompleto()}}</td>
			<td>{{$employee->user->role->name}}</td>
			<td>{{$employee->telefono}}</td>
			<td>{{$employee->fecha_nacimiento}}</td>
			<td>
				@if ($employee->code != null)
				{!!link_to_action('TickeoController@tickeo', $title = 'Tickeos', $parameters = $employee->id, $attributes = ['class'=>'btn btn-warning'])!!}
				@endif
			</td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.employee.edit', $title = 'Editar', $parameters = $employee->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.employee.show', $title = 'Borrar', $parameters = $employee->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$employees->render()!!}
@endsection