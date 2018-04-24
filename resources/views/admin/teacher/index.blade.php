@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	<table class="table table-hover tablaNoOrder compact">
		<thead>
			<th>CIEN</th>
			<th>CI</th>
			<th>Nombre</th>
			<th>Telefono</th>
			<th>Asignaturas</th>
			<th>Horario</th>
			<th>Tickeos</th>
			<th>Edit</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($teachers as $teacher)
			<tr>
				<td>{{$teacher->user->user}}</td>
				<td>{{$teacher->ci}}</td>
				<td>{{$teacher->nombrecompleto()}}</td>
				<td><a href="https://api.whatsapp.com/send?phone=591{{$teacher->telefono}}" target="_blank">{{$teacher->telefono}}</a></td>
				<td style="font-size: 12px;">
					@foreach($teacher->subjects()->orderBy('nombre','asc')->get() as $subject)
					[{{$subject->nombre}}] - 
					@endforeach
				</td>
				<td>
					{!!link_to_action('TeacherController@horario', $title = 'Horario', $parameters = $teacher->id, $attributes = ['class'=>'btn btn-sm btn-success'])!!}
				</td>
				<td>
					@if ($teacher->code != null)
					{!!link_to_action('TickeoController@tickeo', $title = 'Tickeos', $parameters = $teacher->id, $attributes = ['class'=>'btn btn-sm btn-warning'])!!}
					@endif
				</td>
				@foreach(Auth::user()->role->functionalities as $func)
					@if ($func->code=='EDOC')
					<td>
						{!!link_to_route('admin.teacher.edit', $title = 'Editar', $parameters = $teacher->id, $attributes = ['class'=>'btn btn-sm btn-primary'])!!}
					</td>
					@endif
					@if ($func->code=='DDOC')
					<td>
						{!!link_to_route('admin.teacher.show', $title = 'Borrar', $parameters = $teacher->id, $attributes = ['class'=>'btn btn-sm btn-danger'])!!}
					</td>
					@endif
				@endforeach
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection