@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>CI</th>
			<th>Nombre</th>
			<th>Rol</th>
			<th>Telefono</th>
			<th>Fecha Nacimiento</th>
			<th>Tickeo</th>
			<th>Edit</th>
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
				{!!link_to_action('TickeoController@tickeo', $title = 'Tickeos', $parameters = $employee->code, $attributes = ['class'=>'btn btn-warning'])!!}
				@endif
			</td>
			@foreach(Auth::user()->role->functionalities as $func)
			@if ($func->code=='EEMP')
			<td>
				{!!link_to_route('admin.employee.edit', $title = 'Editar', $parameters = $employee->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($func->code=='DEMP')
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