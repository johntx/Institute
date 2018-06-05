@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Session::get('functionalities') as $func) {
	if ($func->code=='EROL'){ $editar=true; }
	if ($func->code=='DROL'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Code</th>
			<th>Name</th>
			<th>Functionalities</th>
			@if ($editar)<th>Edit</th>@endif
			@if ($eliminar)<th>Delete</th>@endif
		</thead>
		@foreach($roles as $role)
		<tbody>
			<td>{{$role->id}}</td>
			<td>{{$role->code}}</td>
			<td>{{$role->name}}</td>
			<td>
				@foreach($role->functionalities as $functionality)
				[{{$functionality->code}}] - 
				@endforeach
			</td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.role.edit', $title = 'Editar', $parameters = $role->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.role.show', $title = 'Borrar', $parameters = $role->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$roles->render()!!}
@endsection