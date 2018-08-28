@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Auth::user()->role->functionalities as $func) {
	if ($func->code=='ESCH'){ $editar=true; }
	if ($func->code=='DSCH'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Nombre</th>
			<th>Vigente</th>
			<th>Ver</th>
			@if ($editar)<th>Editar</th>@endif
			<th>Clonar</th>
			@if ($eliminar)<th>Eliminar</th>@endif
		</thead>
		@foreach($schedules as $schedule)
		<tbody>
			<td>{{$schedule->id}}</td>
			<td>{{$schedule->descripcion}}</td>
			<td>{{$schedule->vigente}}</td>
			<td>
				{!!link_to_action('ScheduleController@ver', $title = 'Ver', $parameters = $schedule->id, $attributes = ['class'=>'btn btn-success'])!!}
			</td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.schedule.edit', $title = 'Editar', $parameters = $schedule->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			<td>
				{!!link_to_action('ScheduleController@clonar', $title = 'Clonar', $parameters = $schedule->id, $attributes = ['class'=>'btn btn-info'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.schedule.show', $title = 'Borrar', $parameters = $schedule->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$schedules->render()!!}
@endsection