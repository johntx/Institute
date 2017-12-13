@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
<table class="table table-hover">
	<thead>
		<th>CIEN</th>
		<th>CI</th>
		<th>Nombre</th>
		<th>Inicio Clases</th>
		<th>Carrera</th>
		<th>Edit</th>
	</thead>
	@foreach($students as $student)
	<tbody>
		<td>{{$student->user->user}}</td>
		<td>{{$student->ci}}</td>
		<td>{{$student->nombrecompleto()}}</td>
		<td>{{$student->inscriptions[0]->group->startclass->fecha_inicio}}</td>
		<td>{{$student->inscriptions[0]->group->startclass->career->nombre}}</td>
		@foreach(Auth::user()->role->functionalities as $func)
		@if ($func->code=='EEST')
		<td>
			{!!link_to_route('admin.student.edit', $title = 'Editar', $parameters = $student->id, $attributes = ['class'=>'btn btn-primary'])!!}
		</td>
		@endif
		@if ($func->code=='DEST')
		<td>
			{!!link_to_route('admin.student.show', $title = 'Borrar', $parameters = $student->id, $attributes = ['class'=>'btn btn-danger'])!!}
		</td>
		@endif
		@endforeach
	</tbody>
	@endforeach
</table>
</div>
{!!$students->render()!!}
@endsection