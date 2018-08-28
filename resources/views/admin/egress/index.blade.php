@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Auth::user()->role->functionalities as $func) {
	if ($func->code=='EEGR'){ $editar=true; }
	if ($func->code=='DEGR'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Glosa</th>
			<th>Monto</th>
			<th>Tipo</th>
			<th>Fecha</th>
			@if ($editar)<th>Editar</th>@endif
			@if ($eliminar)<th>Eliminar</th>@endif
		</thead>
		@foreach($egresses as $egress)
		<tbody>
			<td>{{$egress->id}}</td>
			<td>{{$egress->glosa}}</td>
			<td>{{$egress->monto}}</td>
			<td>{{$egress->tipo}}</td>
			<td>{{Jenssegers\Date\Date::parse($egress->fecha)->format('j M Y')}}</td>
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