@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<?php $editar=false; $eliminar=false; ?>
@foreach(Auth::user()->role->functionalities as $func)
@if ($func->code=='EEGR')
<?php $editar=true; ?>
@endif
@if ($func->code=='DEGR')
<?php $eliminar=true; ?>
@endif
@endforeach
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Glosa</th>
			<th>Monto</th>
			<th>Tipo</th>
			<th>Edit</th>
		</thead>
		@foreach($egresses as $egress)
		<tbody>
			<td>{{$egress->id}}</td>
			<td>{{$egress->glosa}}</td>
			<td>{{$egress->monto}}</td>
			<td>{{$egress->tipo}}</td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.egress.edit', $title = 'Editar', $parameters = $egress->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.egress.show', $title = 'Borrar', $parameters = $egress->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$egresses->render()!!}
@endsection