@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>CIEN</th>
			<th>CI</th>
			<th>Nombre</th>
			<th>Telefono</th>
			<th>Asignaturas</th>
			<th>Horario</th>
			<th>Edit</th>
		</thead>
		@foreach($teachers as $teacher)
		<tbody>
			<td>{{$teacher->user->user}}</td>
			<td>{{$teacher->ci}}</td>
			<td>{{$teacher->nombrecompleto()}}</td>
			<td>{{$teacher->telefono}}</td>
			<td>
				@foreach($teacher->subjects()->orderBy('nombre','asc')->get() as $subject)
				[{{$subject->nombre}}] - 
				@endforeach
			</td>
			<td>
				{!!link_to_action('TeacherController@horario', $title = 'Horario', $parameters = $teacher->id, $attributes = ['class'=>'btn btn-success'])!!}
			</td>
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