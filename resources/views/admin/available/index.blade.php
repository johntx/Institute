@extends('layouts.admin')
@section('content')
@include('alerts.succes')
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
		<th>Edit</th>
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
		@foreach(Auth::user()->role->functionalities as $func)
		@if ($func->code=='EITM')
		<td>
			{!!link_to_route('admin.item.edit', $title = 'Editar', $parameters = $item->id, $attributes = ['class'=>'btn btn-primary'])!!}
		</td>
		@endif
		@if ($func->code=='DITM')
		<td>
			{!!link_to_route('admin.item.show', $title = 'Borrar', $parameters = $item->id, $attributes = ['class'=>'btn btn-danger'])!!}
		</td>
		@endif
		@endforeach
	</tbody>
	@endforeach
</table>
</div>
{!!$items->render()!!}
@endsection