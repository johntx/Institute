@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false; ?>
@foreach(Auth::user()->role->functionalities as $func)
@if ($func->code=='EEST')
<?php $editar=true; ?>
@endif
@if ($func->code=='DEST')
<?php $eliminar=true; ?>
@endif
@endforeach
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>CIEN</th>
			<th>CI</th>
			<th>Nombre</th>
			<th>Ingreso</th>
			<th>Carrera</th>
			<th>Estado</th>
			<th>Edit</th>
		</thead>
		@foreach($students as $student)
		<tbody>
			<td>{{$student->user->user}}</td>
			<td>{{$student->ci}}</td>
			<td><a href="{{url('admin/student/search/'.$student->id)}}" style="color: #0800AB">{{$student->nombrecompleto()}}</a></td>
			<td>{{Jenssegers\Date\Date::parse($student->inscriptions[0]->fecha_ingreso)->format('j M Y')}}</td>
			<td>{{$student->inscriptions[0]->group->startclass->career['nombre']}}</td>
			<td>{{$student->inscriptions[0]->estado}}</td>
			<td>
				{!!link_to_action('StudentController@search', $title = 'Ver', $parameters = $student->id, $attributes = ['class'=>'btn btn-success'])!!}
			</td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.student.edit', $title = 'Editar', $parameters = $student->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.student.show', $title = 'Eliminar', $parameters = $student->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$students->render()!!}
@endsection