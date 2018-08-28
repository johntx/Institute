@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Auth::user()->role->functionalities as $func) {
	if ($func->code=='ESUB'){ $editar=true; }
	if ($func->code=='DSUB'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Nombre</th>
			@if ($editar)<th>Editar</th>@endif
			@if ($eliminar)<th>Eliminar</th>@endif
		</thead>
		@foreach($subjects as $subject)
		<tbody>
			<td>{{$subject->id}}</td>
			<td>{{$subject->nombre}}</td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.subject.edit', $title = 'Editar', $parameters = $subject->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.subject.show', $title = 'Borrar', $parameters = $subject->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$subjects->render()!!}
@endsection