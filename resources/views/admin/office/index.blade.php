@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<?php $editar=false; $eliminar=false; ?>
@foreach(Auth::user()->role->functionalities as $func)
@if ($func->code=='EOFF')
<?php $editar=true; ?>
@endif
@if ($func->code=='DOFF')
<?php $eliminar=true; ?>
@endif
@endforeach
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
			@if ($editar)
			<td>
				{!!link_to_route('admin.office.edit', $title = 'Editar', $parameters = $office->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.office.show', $title = 'Borrar', $parameters = $office->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$offices->render()!!}
@endsection