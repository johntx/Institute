@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
<table class="table table-hover">
	<thead>
		<th>Id</th>
		<th>Code</th>
		<th>Name</th>
		<th>Edit</th>
	</thead>
	@foreach($systems as $system)
	<tbody>
		<td>{{$system->id}}</td>
		<td>{{$system->code}}</td>
		<td>{{$system->name}}</td>
		@foreach(Auth::user()->role->functionalities as $func)
		@if ($func->code=='ESYS')
		<td>
			{!!link_to_route('admin.system.edit', $title = 'Editar', $parameters = $system->id, $attributes = ['class'=>'btn btn-primary'])!!}
		</td>
		@endif
		@if ($func->code=='DSYS')
		<td>
			{!!link_to_route('admin.system.show', $title = 'Borrar', $parameters = $system->id, $attributes = ['class'=>'btn btn-danger'])!!}
		</td>
		@endif
		@endforeach
	</tbody>
	@endforeach
</table>
</div>
{!!$systems->render()!!}
@endsection