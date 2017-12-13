@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
<table class="table table-hover">
	<thead>
		<th>Id</th>
		<th>Nombre</th>
		<th>Duracion</th>
		<th>Costo</th>
		<th>Sucursal</th>
		<th>Edit</th>
	</thead>
	@foreach($careers as $career)
	<tbody>
		<td>{{$career->id}}</td>
		<td>{{$career->nombre}}</td>
		@if ($career->mes > 0)
		<td>{{$career->mes}} - meses</td>
		@else
		<td>{{$career->duracion}} - semanas</td>
		@endif
		<td>{{$career->costo}}</td>
		<td>{{$career->office->nombre}}</td>
		@foreach(Auth::user()->role->functionalities as $func)
		@if ($func->code=='ECAR')
		<td>
			{!!link_to_route('admin.career.edit', $title = 'Editar', $parameters = $career->id, $attributes = ['class'=>'btn btn-primary'])!!}
		</td>
		@endif
		@if ($func->code=='DCAR')
		<td>
			{!!link_to_route('admin.career.show', $title = 'Borrar', $parameters = $career->id, $attributes = ['class'=>'btn btn-danger'])!!}
		</td>
		@endif
		@endforeach
	</tbody>
	@endforeach
</table>
</div>
{!!$careers->render()!!}
@endsection