@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
<table class="table table-hover">
	<thead>
		<th>Id</th>
		<th>Code</th>
		<th>Label</th>
		<th>Path</th>
		<th>menu</th>
		<th>Edit</th>
	</thead>
	@foreach($functionalities as $functionality)
	<tbody>
		<td>{{$functionality->id}}</td>
		<td>{{$functionality->code}}</td>
		<td>{{$functionality->label}}</td>
		<td>{{$functionality->path}}</td>
		<td>{{$functionality->menu->label}}</td>
		@foreach(Auth::user()->role->functionalities as $func)
		@if ($func->code=='EFUN')
		<td>
			{!!link_to_route('admin.functionality.edit', $title = 'Editar', $parameters = $functionality->id, $attributes = ['class'=>'btn btn-primary'])!!}
		</td>
		@endif
		@if ($func->code=='DFUN')
		<td>
			{!!link_to_route('admin.functionality.show', $title = 'Borrar', $parameters = $functionality->id, $attributes = ['class'=>'btn btn-danger'])!!}
		</td>
		@endif
		@endforeach
	</tbody>
	@endforeach
</table>
</div>
{!!$functionalities->render()!!}
@endsection