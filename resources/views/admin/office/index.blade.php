@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
<table class="table table-hover">
	<thead>
		<th>Id</th>
		<th>Nombre</th>
		<th>Direccion</th>
		<th>Edit</th>
	</thead>
	@foreach($offices as $office)
	<tbody>
		<td>{{$office->id}}</td>
		<td>{{$office->nombre}}</td>
		<td>{{$office->direccion}}</td>
		@foreach(Auth::user()->role->functionalities as $func)
		@if ($func->code=='EOFF')
		<td>
			{!!link_to_route('admin.office.edit', $title = 'Editar', $parameters = $office->id, $attributes = ['class'=>'btn btn-primary'])!!}
		</td>
		@endif
		@if ($func->code=='DOFF')
		<td>
			{!!link_to_route('admin.office.show', $title = 'Borrar', $parameters = $office->id, $attributes = ['class'=>'btn btn-danger'])!!}
		</td>
		@endif
		@endforeach
	</tbody>
	@endforeach
</table>
</div>
{!!$offices->render()!!}
@endsection