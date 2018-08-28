@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Auth::user()->role->functionalities as $func) {
	if ($func->code=='EFUN'){ $editar=true; }
	if ($func->code=='DFUN'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Code</th>
			<th>Label</th>
			<th>Path</th>
			<th>menu</th>
			@if ($editar)<th>Edit</th>@endif
			@if ($eliminar)<th>Delete</th>@endif
		</thead>
		@foreach($functionalities as $functionality)
		<tbody>
			<td>{{$functionality->id}}</td>
			<td>{{$functionality->code}}</td>
			<td>{{$functionality->label}}</td>
			<td>{{$functionality->path}}</td>
			<td>{{$functionality->menu->label}}</td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.functionality.edit', $title = 'Editar', $parameters = $functionality->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.functionality.show', $title = 'Borrar', $parameters = $functionality->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$functionalities->render()!!}
@endsection