@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
<table class="table table-hover">
	<thead>
		<th>Id</th>
		<th>Code</th>
		<th>Name</th>
		<th>Functionalities</th>
		<th>Edit</th>
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
		@foreach(Auth::user()->role->functionalities as $func)
		@if ($func->code=='EROL')
		<td>
			{!!link_to_route('admin.role.edit', $title = 'Editar', $parameters = $role->id, $attributes = ['class'=>'btn btn-primary'])!!}
		</td>
		@endif
		@if ($func->code=='DROL')
		<td>
			{!!link_to_route('admin.role.show', $title = 'Borrar', $parameters = $role->id, $attributes = ['class'=>'btn btn-danger'])!!}
		</td>
		@endif
		@endforeach
	</tbody>
	@endforeach
</table>
</div>
{!!$roles->render()!!}
@endsection