@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
<table class="table table-hover">
	<thead>
		<th>Id</th>
		<th>Nombre</th>
		<th>Edit</th>
	</thead>
	@foreach($subjects as $subject)
	<tbody>
		<td>{{$subject->id}}</td>
		<td>{{$subject->nombre}}</td>
		@foreach(Auth::user()->role->functionalities as $func)
		@if ($func->code=='ESUB')
		<td>
			{!!link_to_route('admin.subject.edit', $title = 'Editar', $parameters = $subject->id, $attributes = ['class'=>'btn btn-primary'])!!}
		</td>
		@endif
		@if ($func->code=='DSUB')
		<td>
			{!!link_to_route('admin.subject.show', $title = 'Borrar', $parameters = $subject->id, $attributes = ['class'=>'btn btn-danger'])!!}
		</td>
		@endif
		@endforeach
	</tbody>
	@endforeach
</table>
</div>
{!!$subjects->render()!!}
@endsection