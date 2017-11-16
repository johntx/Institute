@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
<table class="table table-hover">
	<thead>
		<th>Id</th>
		<th>Title</th>
		<th>Text</th>
		<th>Init Date</th>
		<th>End Date</th>
		<th>Place</th>
		<th>Link</th>
		<th>Photos</th>
		<th>Edit</th>
	</thead>
	@foreach($events as $event)
	<tbody>
		<td>{{$event->id}}</td>
		<td>{{$event->title}}</td>
		<td>{{$event->text}}</td>
		<td>{{$event->date}}</td>
		<td>{{$event->enddate}}</td>
		<td>{{$event->place}}</td>
		<td>{{$event->link}}</td>
		<td>
			@foreach($event->images as $image)
			<img src="{!!URL::to($image->photo)!!}" alt="" height="50px">
			@endforeach
		</td>
		@foreach(Auth::user()->role->functionalities as $func)
		@if ($func->code=='EEVT')
		<td>
			{!!link_to_route('admin.event.edit', $title = 'Editar', $parameters = $event->id, $attributes = ['class'=>'btn btn-primary'])!!}
		</td>
		@endif
		@if ($func->code=='DEVT')
		<td>
			{!!link_to_route('admin.event.show', $title = 'Borrar', $parameters = $event->id, $attributes = ['class'=>'btn btn-danger'])!!}
		</td>
		@endif
		@endforeach
	</tbody>
	@endforeach
</table>
</div>
{!!$events->render()!!}
@endsection