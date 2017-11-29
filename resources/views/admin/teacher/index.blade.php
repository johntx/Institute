@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
<table class="table table-hover">
	<thead>
		<th>CIEN</th>
		<th>CI</th>
		<th>Nombre</th>
		<th>Ingreso</th>
		<th>Nacionalidad</th>
		<th>Direccion</th>
		<th>Telefono</th>
		<th>Edit</th>
	</thead>
	@foreach($teachers as $teacher)
	<tbody>
		<td>{{$teacher->user->user}}</td>
		<td>{{$teacher->ci}}</td>
		<td>{{$teacher->nombrecompleto()}}</td>
		<td>{{$teacher->fecha_ingreso}}</td>
		<td>{{$teacher->nacionalidad}}</td>
		<td>{{$teacher->direccion}}</td>
		<td>{{$teacher->telefono}}</td>
		@foreach(Auth::user()->role->functionalities as $func)
		@if ($func->code=='EDOC')
		<td>
			{!!link_to_route('admin.teacher.edit', $title = 'Editar', $parameters = $teacher->id, $attributes = ['class'=>'btn btn-primary'])!!}
		</td>
		@endif
		@if ($func->code=='DDOC')
		<td>
			{!!link_to_route('admin.teacher.show', $title = 'Borrar', $parameters = $teacher->id, $attributes = ['class'=>'btn btn-danger'])!!}
		</td>
		@endif
		@endforeach
	</tbody>
	@endforeach
</table>
</div>
{!!$teachers->render()!!}
@endsection