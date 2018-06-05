@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Session::get('functionalities') as $func) {
	if ($func->code=='EMEN'){ $editar=true; }
	if ($func->code=='DMEN'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Code</th>
			<th>Label</th>
			<th>Icon</th>
			@if ($editar)<th>Edit</th>@endif
			@if ($eliminar)<th>Delete</th>@endif
		</thead>
		@foreach($menus as $menu)
		<tbody>
			<td>{{$menu->id}}</td>
			<td>{{$menu->code}}</td>
			<td>{{$menu->label}}</td>
			<td><i class="fa fa-{{$menu->icon}} fa-fw"></i></td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.menu.edit', $title = 'Editar', $parameters = $menu->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.menu.show', $title = 'Borrar', $parameters = $menu->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$menus->render()!!}
@endsection