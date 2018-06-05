@extends('layouts.admin')
@section('content')
<div class="table-responsive">
	<table class="table table-responsive">
		<thead>
			<th>Id</th>
			<th>Usuario</th>
			<th>Rol</th>
			<th>Editar</th>
		</thead>
		@foreach($users as $user)
		<tbody>
			<td>{{$user->id}}</td>
			<td>{{$user->user}}</td>
			<td>{{$user->role->name}}</td>
			@foreach(Auth::user()->role->functionalities as $func)
			@if ($func->code=='EUSR')
			<td>
				{!!link_to_route('user.edit', $title = 'Edit', $parameters = $user->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($func->code=='DUSR')
			<td>
				{!!link_to_route('user.show', $title = 'Delete', $parameters = $user->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
			@endforeach
		</tbody>
		@endforeach
	</table>
</div>
{!!$users->render()!!}
@endsection