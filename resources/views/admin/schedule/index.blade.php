@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Nombre</th>
			<th>Vigente</th>
			<th>Opcion</th>
		</thead>
		@foreach($schedules as $schedule)
		<tbody>
			<td>{{$schedule->id}}</td>
			<td>{{$schedule->descripcion}}</td>
			<td>{{$schedule->vigente}}</td>
			<td>
				{!!link_to_action('ScheduleController@ver', $title = 'Ver', $parameters = $schedule->id, $attributes = ['class'=>'btn btn-success'])!!}
			</td>
			@foreach(Auth::user()->role->functionalities as $func)
			@if ($func->code=='ESCH')
			<td>
				{!!link_to_route('admin.schedule.edit', $title = 'Editar', $parameters = $schedule->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			<td>
				{!!link_to_action('ScheduleController@clonar', $title = 'Clonar', $parameters = $schedule->id, $attributes = ['class'=>'btn btn-info'])!!}
			</td>
			@endif
			@if ($func->code=='DSCH')
			<td>
				{!!link_to_route('admin.schedule.show', $title = 'Borrar', $parameters = $schedule->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
			@endforeach
		</tbody>
		@endforeach
	</table>
</div>
{!!$schedules->render()!!}
@endsection