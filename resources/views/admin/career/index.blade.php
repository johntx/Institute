@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Nombre</th>
			<th>Color</th>
			<th>Asignaturas</th>
			<th>Edit</th>
		</thead>
		@foreach($careers as $career)
		<tbody>
			<td>{{$career->id}}</td>
			<td>{{$career->nombre}}</td>
			<td><div class="btn-group"><button type="button" class="btn" style="background-color: {{$career->color}}; color: {{$career->texto}};">color</button></div></td>
			<td>
				@foreach($career->subjects()->orderBy('nombre','asc')->get() as $subject)
				[{{$subject->nombre}}] - 
				@endforeach
			</td>
			@foreach(Auth::user()->role->functionalities as $func)
			@if ($func->code=='ECAR')
			<td>
				{!!link_to_route('admin.career.edit', $title = 'Editar', $parameters = $career->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($func->code=='DCAR')
			<td>
				{!!link_to_route('admin.career.show', $title = 'Borrar', $parameters = $career->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
			@endforeach
		</tbody>
		@endforeach
	</table>
</div>
{!!$careers->render()!!}
@endsection