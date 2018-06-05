@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Session::get('functionalities') as $func) {
	if ($func->code=='EEXT'){ $editar=true; }
	if ($func->code=='DEXT'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Nombre</th>
			<th>Precio</th>
			<th>Inscritos</th>
			@if ($editar)<th>Editar</th>@endif
			@if ($eliminar)<th>Eliminar</th>@endif
		</thead>
		<tbody>
			@foreach($extras as $extra)
			<tr>
				<td>{{$extra->id}}</td>
				<td>{{$extra->nombre}}</td>
				<td>{{$extra->precio}}</td>
				<td>
					{!!link_to_action('ExtraController@curso', $title = 'Estudiantes', $parameters = $extra->id, $attributes = ['class'=>'btn btn-info'])!!}
				</td>
				@if ($editar)
				<td>
					{!!link_to_route('admin.extra.edit', $title = 'Editar', $parameters = $extra->id, $attributes = ['class'=>'btn btn-primary'])!!}
				</td>
				@endif
				@if ($eliminar)
				<td>
					{!!link_to_route('admin.extra.show', $title = 'Borrar', $parameters = $extra->id, $attributes = ['class'=>'btn btn-danger'])!!}
				</td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
{!!$extras->render()!!}
@endsection