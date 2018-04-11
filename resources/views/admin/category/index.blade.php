@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<?php $editar=false; $eliminar=false;?>
@foreach(Auth::user()->role->functionalities as $func)
@if ($func->code=='ECAT')
<?php $editar=true; ?>
@endif
@if ($func->code=='DCAT')
<?php $eliminar=true; ?>
@endif
@endforeach
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Nombre</th>
			<th>Edit</th>
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