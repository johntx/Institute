@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Session::get('functionalities') as $func) {
	if ($func->code=='EITM'){ $editar=true; }
	if ($func->code=='DITM'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Nombre</th>
			<th>Detalles</th>
			<th>Hojas</th>
			<th>Costo</th>
			<th>Precio</th>
			<th>Stock</th>
			<th>Categoría</th>
			<th>Carrera</th>
			@if ($editar)<th>Editar</th>@endif
			@if ($eliminar)<th>Eliminar</th>@endif
		</thead>
		@foreach($items as $item)
		<tbody>
			<td>{{$item->id}}</td>
			<td>{{$item->nombre}}</td>
			<td>{{$item->detalle}}</td>
			<td>{{$item->hojas}}</td>
			<td>{{$item->costo}}</td>
			<td>{{$item->precio}}</td>
			<td><b>{{$item->stock}}</b></td>
			<td>{{$item->category['nombre']}}</td>
			<td>{{$item->career['nombre']}}</td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.item.edit', $title = 'Editar', $parameters = $item->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.item.show', $title = 'Borrar', $parameters = $item->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$items->render()!!}
@endsection