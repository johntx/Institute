@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
<table class="table table-hover">
	<thead>
		<th>CI</th>
		<th>Nombre</th>
		<th>Ingreso</th>
		<th>Nacionalidad</th>
		<th>Direccion</th>
		<th>Telefono</th>
		<th>Edit</th>
	</thead>
	@foreach($employees as $employee)
	<tbody>
		<td>{{$employee->ci}}</td>
		<td>{{$employee->nombrecompleto()}}</td>
		<td>{{$employee->fecha_ingreso}}</td>
		<td>{{$employee->nacionalidad}}</td>
		<td>{{$employee->direccion}}</td>
		<td>{{$employee->telefono}}</td>
		@foreach(Auth::user()->role->functionalities as $func)
		@if ($func->code=='EEST')
		<td>
			{!!link_to_route('admin.employee.edit', $title = 'Editar', $parameters = $employee->id, $attributes = ['class'=>'btn btn-primary'])!!}
		</td>
		@endif
		@if ($func->code=='DEST')
		<td>
			{!!link_to_route('admin.employee.show', $title = 'Borrar', $parameters = $employee->id, $attributes = ['class'=>'btn btn-danger'])!!}
		</td>
		@endif
		@endforeach
	</tbody>
	@endforeach
</table>
</div>
{!!$employees->render()!!}
@endsection