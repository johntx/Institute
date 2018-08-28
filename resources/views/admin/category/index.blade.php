@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Auth::user()->role->functionalities as $func) {
	if ($func->code=='ECAT'){ $editar=true; }
	if ($func->code=='DCAT'){ $eliminar=true; }
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
		@foreach($categories as $category)
		<tbody>
			<td>{{$category->id}}</td>
			<td>{{$category->nombre}}</td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.category.edit', $title = 'Editar', $parameters = $category->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.category.show', $title = 'Borrar', $parameters = $category->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$categories->render()!!}
@endsection